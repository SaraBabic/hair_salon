<?php

namespace App\Form;

use App\Entity\Salon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SalonForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your salons name',
                    ])
                ],
            ])
            ->add('city', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your salons city',
                    ])
                ],
            ])
            ->add('address', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your salons address',
                    ])
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your salons phone number',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr'=>['class'=>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your salons description',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salon::class
        ]);
    }
}