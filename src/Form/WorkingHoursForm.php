<?php

namespace App\Form;

use App\Entity\SalonWorkingHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkingHoursForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $salonWorkingHours = [];
        /** @var SalonWorkingHours $dayHours */
        foreach ($options['hours'] as $dayHours) {
            $salonWorkingHours[$dayHours->getDay()] = [
                'from' => $dayHours->getOpeningAt(),
                'to' => $dayHours->getClosingAt(),
            ];
        }

        $defaultChoices = [
            'closed' => null,
            '07' => '07:00:00',
            '08' => '08:00:00',
            '09' => '09:00:00',
            '10' => '10:00:00',
            '11' => '11:00:00',
            '12' => '12:00:00',
            '13' => '13:00:00',
            '14' => '14:00:00',
            '15' => '15:00:00',
            '16' => '16:00:00',
            '17' => '17:00:00',
            '18' => '18:00:00',
            '19' => '19:00:00',
            '20' => '20:00:00',
            '21' => '21:00:00',
        ];

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $idx => $day) {
            $dayNumber = $idx+1;
            $from = ($day !== 'sunday') ? '07:00:00' : null;
            $to = ($day !== 'sunday') ? '21:00:00' : null;
            $labelFrom = "{$day} from";
            $labelTo = "{$day} to";
            $attr = ($day !== 'monday') ? ['class'=>'form-control'] : ['class'=>'form-control monday'];

            $builder->add("{$day}From", ChoiceType::class, [
                'attr'=> $attr,
                'label' => $labelFrom,
                'choices' => array_keys($defaultChoices),
                'choice_label' => function ($choice, $key, $value){
                    return $value;
                },
                'data' => isset($salonWorkingHours[$dayNumber]['from']) ? substr($salonWorkingHours[$dayNumber]['from'], 0, 2) : $from,
            ]);
            $builder->add("{$day}To", ChoiceType::class, [
                'attr'=> $attr,
                'label' => $labelTo,
                'choices' => array_keys($defaultChoices),
                'choice_label' => function ($choice, $key, $value){
                    return $value;
                },
                'data' => isset($salonWorkingHours[$dayNumber]['to']) ? substr($salonWorkingHours[$dayNumber]['to'], 0, 2) :  $to,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'hours' => null
        ]);
    }
}
