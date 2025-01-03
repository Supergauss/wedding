<?php

namespace App\Form;

use App\Entity\Invitation;
use App\Entity\GuestTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number_guests_invited',
                IntegerType::class,
                [
                    'data' => 1,
                    'attr' => [
                        'placeholder' => 'number_guests_invited',
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
