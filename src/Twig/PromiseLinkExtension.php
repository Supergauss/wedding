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
            $html .= "Wir laden euch hiermit herzlich 
zu unserer Hochzeit am 28.05.2025 ein.<br>
Details findet ihr im Link zu 
unserer Hochzeitswebsite.<br>
Bitte gebt uns Rückmeldung bis 
zum 28.02. ob Ihr dabei seid.<br><br>
Mit Vorfreude und ganz lieben Grüßen,<br>
Susanna & Dennis";
        } else {
            $html .= "Wir laden dich hiermit herzlich 
zu unserer Hochzeit am 28.05.2025 ein.<br>
Details findest du im Link zu 
unserer Hochzeitswebsite.<br>
Bitte gib uns Rückmeldung bis 
zum 28.02. ob du dabei bist.<br><br>
Mit Vorfreude und ganz lieben Grüßen,<br>
Susanna & Dennis";
        }

         return $html;
    }



    public function promiseLink(Invitation $invitation): string
    {
        $url = $this->router->generate('promise',['id' => $invitation->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return '<a href="#" onclick="navigator.clipboard.writeText(\''.$url.'\')">Link kopieren für '.$invitation->getName().'</a>';
    }
}