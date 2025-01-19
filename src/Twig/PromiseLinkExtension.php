<?php

namespace App\Twig;
use App\Entity\Invitation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PromiseLinkExtension extends AbstractExtension
{
    public function __construct(protected RouterInterface $router, protected readonly GrammatikExtension $extension)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('promiseHtml', [$this, 'promiseHtml']),
            new TwigFunction('promiseLink', [$this, 'promiseLink']),
        ];
    }

    public function promiseHtml(Invitation $invitation): string
    {
        $url = $this->router->generate('promise',['id' => $invitation->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        $salutation = 'Lieber '.$invitation->getName();
        if(in_array($invitation->getSalutation()->name, ['MULTI','SINGLE_FEMALE'])){
            $salutation =  'Liebe '.$invitation->getName();
        }


        $html = $this->extension->salutation($invitation). ' '.$invitation->getName().",<br><br>";
        if(in_array($invitation->getSalutation()->name, ['MULTI'])){
            $html .= "Wir laden euch hiermit herzlich zu unserer Hochzeit am 28.05.2025 ein.<br>
Details findet ihr im Link.<br><br>
Mit Vorfreude und ganz lieben Grüßen,<br>
Susanna & Dennis<br><br>";
        } else {
            $html .= "Wir laden dich hiermit herzlich zu unserer Hochzeit am 28.05.2025 ein.<br>
Details findest du im Link.<br><br>
Mit Vorfreude und ganz lieben Grüßen,<br>
Susanna & Dennis<br><br>";
        }

         return $html;
    }



    public function promiseLink(Invitation $invitation): string
    {
        $url = $this->router->generate('promise',['id' => $invitation->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        //return '<a href="#" onclick="navigator.clipboard.writeText(\''.$url.'\')">Link kopieren für '.$invitation->getName().'</a>';
        return '<a href="'.$url.'">Link kopieren für '.$invitation->getName().'</a>';
    }
}