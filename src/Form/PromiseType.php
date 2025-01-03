<?php

namespace App\Form;

use App\Entity\Invitation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Invitation $invitation */
        $invitation = $builder->getData();
        if($invitation->getNumberGuestsInvited() > 1){
            $builder->add('number_guests_promised', IntegerType::class,
            [
                'attr' => ['max' => $invitation->getNumberGuestsInvited(), 'min' => 1]
            ]);
        }
        $builder
            ->add('promised', ChoiceType::class, [
                'choices' => [
                    'Ja' => 1,
                    'Nein' => 0
                ]
            ])
            ->add('guest_comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invitation::class,
        ]);
    }
}
