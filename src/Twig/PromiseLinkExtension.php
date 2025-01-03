<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PromiseLinkExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('promiseLink', [$this, 'promiseLink']),
        ];
    }

    public function promiseLink(Invitation $invitation): string
    {
        $url = $this->router->generate('promise',['id' => $invitation->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

         return '<a href="#" onclick="navigator.clipboard.writeText(\''.$url.'\')">Link kopieren für '.$invitation->getName().'</a>';
    }
}