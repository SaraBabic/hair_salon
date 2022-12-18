<?php

namespace App\Form;

use App\Entity\Salon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkingHoursForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mondayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Monday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('mondayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Monday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('tuesdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Tuesday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('tuesdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Tuesday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('wednesdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Wednesday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('wednesdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Wednesday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('thursdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Thursday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('thursdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Thursday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('fridayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Friday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('fridayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Friday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('saturdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Saturday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('saturdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Saturday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('sundayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Sunday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('sundayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Sunday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ]);
    }
}
