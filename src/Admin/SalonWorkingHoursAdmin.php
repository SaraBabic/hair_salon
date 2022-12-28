<?php

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SalonWorkingHoursAdmin extends \Sonata\AdminBundle\Admin\AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('day')
            ->add('openingAt')
            ->add('closingAt')
            ;
    }

    protected function configureRoutes(RouteCollection|\Sonata\AdminBundle\Route\RouteCollectionInterface $collection):void
    {
        $collection->clearExcept(array('edit'));
    }
}