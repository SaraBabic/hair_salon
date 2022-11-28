<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

final class SalonOwnerFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

    }

    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'roles' => ['ROLE_SALON_OWNER'],
            'password' => '$2a$12$8gHJbA9QGGu7NQ82J1vooOJi6/9BoQu/l4G8r4THP5lDgTfdfGcaq',
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'phoneNumber' => self::faker()->phoneNumber(),
            'isVerified' => true,
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
