<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// dir
class DativExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dativ', [$this, 'dativ']),
        ];
    }

    public function dativ(Invitation $invitation): string
    {
        if($invitation->getNumberGuestsInvited() > 1){
            return 'euch';
        }
        return 'dir';
    }
}