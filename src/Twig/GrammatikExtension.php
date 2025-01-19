<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// dir
class GrammatikExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dativ', [$this, 'dativ']),
            new TwigFunction('akkusativ', [$this, 'akkusativ']),
            new TwigFunction('pronomen', [$this, 'pronomen']),
        ];
    }

    public function dativ(Invitation $invitation): string
    {
        if($invitation->getNumberGuestsInvited() > 1){
            return 'euch';
        }
        return 'dir';
    }

    public function akkusativ(Invitation $invitation): string
    {
        if($invitation->getNumberGuestsInvited() > 1){
            return 'euch';
        }
        return 'dich';
    }

    public function pronomen(Invitation $invitation): string
    {
        if($invitation->getNumberGuestsInvited() > 1){
            return 'eure';
        }
        return 'deine';
    }
}