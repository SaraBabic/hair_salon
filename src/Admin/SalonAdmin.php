<?php

namespace App\Admin;

use App\Entity\SalonServices;
use App\Entity\SalonWorkingHours;
use App\Entity\User;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SalonAdmin extends \Sonata\AdminBundle\Admin\AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('description', TextareaType::class)
            ->add('imagePath', TextType::class)
            ->add('isActive')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name')
            ->add('isActive')
            ->add('city')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name')
            ->addIdentifier('isActive')
            ->addIdentifier('address')
            ->addIdentifier('city')
            ->addIdentifier('imagePath') //TODO show image
            ->addIdentifier('owner',EntityType::class, ['class' => User::class])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name')
            ->add('isActive')
            ->add('address')
            ->add('city')
            ->add('owner',EntityType::class, [ 'class' => User::class])
          //  ->add('salonServices', EntityType::class, ['class' => SalonServices::class])
          //  ->add('salonWorkingHours', EntityType::class, ['class' => SalonWorkingHours::class])
            //TODO how to show services and working hours
        ;
    }
}