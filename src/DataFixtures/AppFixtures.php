<?php

namespace App\DataFixtures;

use App\Factory\SalonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        SalonFactory::createMany(20);

        $manager->flush();
    }
}
