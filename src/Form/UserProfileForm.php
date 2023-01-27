<?php

namespace App\Form;

use App\Entity\HairdresserDetails;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserProfileForm extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a first name',
                    ])
                    ],
            ])
            ->add('lastName', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a last name',
                    ])
                ],
            ])
            ->add('phoneNumber', TelType::class, [
                'attr' => [ 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a phone number',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}