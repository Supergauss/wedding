<?php

namespace App\Form;

use App\Entity\Invitation;
use App\Entity\GuestTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Invitation $invitation */
        $invitation = $builder->getData();
        if($invitation->getNumberGuestsInvited() > 1){

            $builder->add('number_guests_promised', IntegerType::class,
                [
                    'attr' => ['max' => $invitation->getNumberGuestsInvited(), 'min' => 0],
                    'data' => $invitation->getNumberGuestsPromised() ?: $invitation->getNumberGuestsInvited(),
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                ]);
        }
        $builder
            ->add('promised', ChoiceType::class, [
                'choices' => [
                    'Ja' => 1,
                    'Nein' => 0
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
        ;
        $builder
            ->add('number_guests_invited',
                IntegerType::class,
                [
                    'empty_data' => 1,
                    'attr' => [
                        'placeholder' => 'number_guests_invited',
                        'min' => 1,
                        'max' => 6
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                ]
            )
            ->add('salutation',
                EnumType::class,
                [
                    'attr' => [
                        'placeholder' => 'name',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'class' => GuestTypeEnum::class
                ])
            ->add('name',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'name',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                ])
            ->add('is_family');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invitation::class,
        ]);
    }
}
