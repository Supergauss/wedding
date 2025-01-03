<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// dich, euch
class AkkusativExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('akkusativ', [$this, 'akkusativ']),
        ];
    }

    public function akkusativ(Invitation $invitation): string
    {
        if($invitation->getNumberGuestsInvited() > 1){
            return 'euch';
        }
        return 'dich';
    }
}