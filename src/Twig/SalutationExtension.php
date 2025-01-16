<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

// Liebe
class SalutationExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('salutation', [$this, 'salutation']),
        ];
    }

    public function salutation(Invitation $invitation): string
    {
        if(in_array($invitation->getSalutation()->name, ['MULTI','SINGLE_FEMALE'])){
            return 'Liebe';
        }
        return 'Lieber';
    }
}