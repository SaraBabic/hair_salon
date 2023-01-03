<?php

namespace App\Form;

use App\Entity\Salon;
use App\Entity\SalonWorkingHours;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkingHoursForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $defaultData = [];
        /** @var SalonWorkingHours $dayHours */
        foreach ($options['hours'] as $dayHours) {
            $defaultData[$dayHours->getDay()] = [
                'from' => $dayHours->getOpeningAt(),
                'to' => $dayHours->getClosingAt(),
            ];
        }

        $builder
            ->add('mondayFrom', TextType::class, [
                'attr'=>['class'=>'form-control monday'],
                'label' => 'Monday from',
                'data' => $defaultData[1]['from'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('mondayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Monday to',
                'data' => $defaultData[1]['to'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('tuesdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label' => 'Tuesday from',
                'data' => $defaultData[2]['from'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('tuesdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[2]['to'],
                'label' => 'Tuesday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('wednesdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[3]['from'],
                'label' => 'Wednesday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('wednesdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[3]['to'],
                'label' => 'Wednesday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('thursdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[4]['from'],
                'label' => 'Thursday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('thursdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[4]['to'],
                'label' => 'Thursday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('fridayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[5]['from'],
                'label' => 'Friday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('fridayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[5]['to'],
                'label' => 'Friday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('saturdayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[6]['from'],
                'label' => 'Saturday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('saturdayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[6]['to'],
                'label' => 'Saturday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ])
            ->add('sundayFrom', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[7]['from'],
                'label' => 'Sunday from',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Start at',
                    ])
                ],
            ])
            ->add('sundayTo', TextType::class, [
                'attr'=>['class'=>'form-control'],
                'data' => $defaultData[7]['to'],
                'label' => 'Sunday to',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Close at',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => SalonWorkingHours::class,
            'hours' => null
        ]);
    }
}
