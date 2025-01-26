<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Invitation;
use App\Form\ImageType;
use App\Form\PromiseType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromiseController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/promise/{id}', name: 'promise', methods: ['GET', 'POST'])]
    public function familyPromise(string $id, EntityManagerInterface $entityManager, Request $request, FileUploader $fileUploader): Response
    {
        $invitation = $entityManager->getRepository(Invitation::class)->find($id);

        if ($invitation instanceof Invitation) {

            if ($invitation->getDateMustPromise()->format('U') > time()) {
                $form = $this->createForm(PromiseType::class, $invitation);
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        /** @var Invitation $invitation */
                        $invitation = $form->getData();
                        $invitation->setDatePromised(new \DateTime());

                        $entityManager->persist($invitation);
                        $entityManager->flush();
                        if($invitation->isPromised()){
                            $this->addFlash('success', 'Vielen Dank für die Zusage');
                        } else {
                            $this->addFlash('success', 'Schade, dass du abgesagt hast.');
                        }

                        return $this->redirectToRoute('promise', ['id' => $id]);
                    }
                }

                $formGallery = $this->createForm(ImageType::class);
                $formGallery->handleRequest($request);
                if ($formGallery->isSubmitted() && $formGallery->isValid()) {
                    /** @var UploadedFile $image */
                    foreach ($formGallery->get('images')->getData() as $key => $image) {
                        if ($image) {
                            $imageFilename = $fileUploader->upload($image);
                            $imageEntity = new Image();
                            $imageEntity->setFilename($imageFilename);
                            $invitation->addImage($imageEntity);
                            $entityManager->persist($imageEntity);
                            $entityManager->flush();
                        }
                    }
                    $entityManager->persist($invitation);
                    $entityManager->flush();
                    $this->addFlash('success', 'Die Bilder wurden erfolgreich hinzugefügt und müssen nun freigegeben werden.');
                    return $this->redirectToRoute('promise', ['id' => $id]);
                }
                return $this->render('promise/index.html.twig', [
                    'invitation' => $invitation,
                    'form' => $form->createView(),
                    'formGallery' => $formGallery->createView()
                ]);
            } else {
                $this->addFlash('danger', 'Der Zusagezeitraum ist abgelaufen');
                return $this->redirectToRoute('promise', ['id' => $id]);
            }
        } else {

            $this->addFlash('danger', 'Anscheinend wurden Sie aber nicht eingeladen, schade schade');
            return $this->redirect($this->generateUrl('app_index'));
        }
    }

    #[Route('/gallery/{id}', name: 'gallery', methods: ['GET', 'POST'])]
    public function gallery(string $id, EntityManagerInterface $entityManager, Request $request, FileUploader $fileUploader): Response
    {
        $invitation = $entityManager->getRepository(Invitation::class)->find($id);
        $images = $entityManager->getRepository(Image::class)->findBy(['released' => true]);
        return $this->render('promise/gallery.html.twig', [
            'invitation' => $invitation,
            'images' => $images
        ]);
    }
}
