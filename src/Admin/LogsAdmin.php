<?php

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LogsAdmin extends \Sonata\AdminBundle\Admin\AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {}

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('deviceType')
            ->add('userAgent')
            ->add('ipAddress')
            ->add('continent')
            ->add('country')
            ->add('region')
            ->add('provider')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('user', EntityType::class, ['class' => User::class])
            ->addIdentifier('deviceType')
            ->addIdentifier('userAgent')
            ->addIdentifier('ipAddress')
            ->addIdentifier('continent')
            ->addIdentifier('country')
            ->addIdentifier('region')
            ->addIdentifier('provider');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('user', EntityType::class, ['class' => User::class])
            ->add('deviceType')
            ->add('userAgent')
            ->add('ipAddress')
            ->add('continent')
            ->add('country')
            ->add('region')
            ->add('provider');
    }
}