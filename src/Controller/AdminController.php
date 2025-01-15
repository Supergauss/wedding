<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Form\InvitationType;
use App\Repository\ImageRepository;
use App\Repository\InvitationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '', name: 'index')]
    public function index(Request $request, InvitationRepository $invitationRepository): Response
    {
        $existingInvitations = $invitationRepository->findAll();
        return $this->render('admin/index.html.twig',
        [
            'existingInvitations' => $existingInvitations
        ]);
    }

    #[Route('/invitation/edit/{id?}', name: 'invitation_edit', methods: ['GET', 'POST'])]
    #[Route('/invitation/new', name: 'invitation_new', methods: ['GET', 'POST'])]
    public function invitation(Request $request, EntityManagerInterface $entityManager, ?string $id = null): Response
    {
        if ($id) {
            $invitation = $entityManager->getRepository(Invitation::class)->find($id);
        } else {
            $invitation = new Invitation();
        }

        $form = $this->createForm(InvitationType::class, $invitation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Invitation $invitation */
            $invitation = $form->getData();
            if(empty($invitation->getDateMustPromise())){
                $invitation->setDateMustPromise(new \DateTime());
            }

            $entityManager->persist($invitation);
            $entityManager->flush();
            $this->addFlash('success', $invitation->getName().' wurde angelegt');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/invitation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/invitation/delete/{id}', name: 'invitation_delete', methods: ['GET'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, string $id): Response
    {
        $invitation = $entityManager->getRepository(Invitation::class)->find($id);
        $entityManager->remove($invitation);
        $entityManager->flush();
        $this->addFlash('success', 'Die neue Einladung wurde gelöscht ihr Wichser');
        return $this->redirectToRoute('admin_index');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/gallery', name: 'gallery')]
    public function gallery( InvitationRepository $invitationRepository): Response
    {
        $existingInvitations = $invitationRepository->findAll();
        return $this->render('admin/gallery.html.twig',
            [
                'existingInvitations' => $existingInvitations
            ]);
    }

    #[Route(path: '/gallery/release/{id}', name: 'gallery_release', methods: ['POST'])]
    public function release(int $id, ImageRepository $imageRepository,EntityManagerInterface $entityManager,Request $request): JsonResponse
    {
        $image = $imageRepository->find($id);
        $image->setReleased((bool)$request->get('released'));
        $entityManager->persist($image);
        $entityManager->flush();
        return new JsonResponse(['success']);
    }
}
