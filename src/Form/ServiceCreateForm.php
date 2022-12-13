<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ServiceCreateForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serviceName', TextType::class, [
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('servicePrice', NumberType::class, [
                'attr' => [ 'class' => 'form-control'],
                'html5' => true,
                'label' => "Service Price ( din )",
                'constraints' => [
                    new Range([
                        'min' => '50',
                        'max' => '10000'
                    ]),
                ]
            ])
            ->add('serviceDuration', NumberType::class, [
                'attr' => [ 'class' => 'form-control'],
                'html5' => true,
                'label' => 'Service Duration ( min )',
                'constraints' => [
                    new Range([
                        'min' => '10',
                        'max' => '250'
                    ]),
                ]
            ])
        ;

    }
}