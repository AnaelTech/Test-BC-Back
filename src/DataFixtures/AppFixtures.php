<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [
                'email' => 'user1@example.com',
                'roles' => ['ROLE_USER'],
                'password' => 'password1',
                'name' => 'John',
                'lastname' => 'Doe',
                'birthday' => new \DateTime('1990-01-01'),
                'adresse' => '123 Main St',
                'genre' => ['Male']
            ],
            [
                'email' => 'admin@example.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'adminpassword',
                'name' => 'Jane',
                'lastname' => 'Doe',
                'birthday' => new \DateTime('1985-01-01'),
                'adresse' => '456 Main St',
                'genre' => ['Female']
            ],
            // Add more users here if needed
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $hashedPassword = $this->userPasswordHasherInterface->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            $user->setName($userData['name']);
            $user->setLastname($userData['lastname']);
            $user->setBirthday($userData['birthday']);
            $user->setAdresse($userData['adresse']);
            $user->setGenre($userData['genre']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
