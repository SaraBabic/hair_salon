<?php

namespace App\Factory;

use App\Entity\Salon;
use App\Repository\SalonRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

final class SalonFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(25),
            'address' => self::faker()->address(),
            'city' => self::faker()->city(),
            'isActive' => self::faker()->boolean(85),
            'phoneNumber' => self::faker()->phoneNumber(),
            'description' => self::faker()->realText(350),
            'imagePath' => 'https://api.lorem.space/image/house?w=150&h=150'
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Salon $salon): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Salon::class;
    }
}
