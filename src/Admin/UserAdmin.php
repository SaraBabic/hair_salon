<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends \Sonata\AdminBundle\Admin\AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('email', EmailType::class)
            ->add('isVerified')
            ->add('isBanned')
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('rolesAsString', TextType::class, [
                'required' => false,
                'help' => 'write roles like: ROLE_x, ROLE_y...'
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('email')
            ->add('isVerified')
            ->add('isBanned')
            ->add('firstName')
            ->add('lastName')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('email')
            ->addIdentifier('isVerified')
            ->add('isBanned')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('email')
            ->add('isVerified')
            ->add('isBanned')
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('roles');
    }
}

/*
 *
configureFormFields(): This method configures which fields are displayed on the edit and create actions.
                       The FormMapper behaves similar to the FormBuilder of the Symfony Form component;
configureDatagridFilters(): This method configures the filters, used to filter and sort the list of models;
configureListFields(): This method configures which fields are shown when all models are listed
                       (the addIdentifier() method means that this field will link to the show/edit page
                       of this particular model);
configureShowFields(): This method configures which fields are displayed on the show action.
 *
 */