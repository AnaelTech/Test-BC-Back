<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Prestation;
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
                'genre' => ['Male'],
                'picture' => 'https://picsum.photos/200/300'
            ],
            [
                'email' => 'admin@example.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'adminpassword',
                'name' => 'Jane',
                'lastname' => 'Doe',
                'birthday' => new \DateTime('1985-01-01'),
                'adresse' => '456 Main St',
                'genre' => ['Female'],
                'picture' => 'https://picsum.photos/200/300'
            ],
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
            $user->setPicture($userData['picture']);

            $manager->persist($user);
        }

        // Create categories
        $category1 = new Category();
        $category1->setName('Vêtements');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Linge de maison');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Chaussures');
        $manager->persist($category3);

        // Create subcategories
        $subcategory1 = new Category();
        $subcategory1->setName('T-Shirts');
        $subcategory1->setParent($category1);
        $manager->persist($subcategory1);

        $subcategory2 = new Category();
        $subcategory2->setName('Pantalons');
        $subcategory2->setParent($category1);
        $manager->persist($subcategory2);

        $subcategory3 = new Category();
        $subcategory3->setName('Draps');
        $subcategory3->setParent($category2);
        $manager->persist($subcategory3);

        $subcategory4 = new Category();
        $subcategory4->setName('Serviettes');
        $subcategory4->setParent($category2);
        $manager->persist($subcategory4);

        $categories = [
            'Vêtements' => $category1,
            'Linge de maison' => $category2,
            'Chaussures' => $category3,
            'T-Shirts' => $subcategory1,
            'Pantalons' => $subcategory2,
            'Draps' => $subcategory3,
            'Serviettes' => $subcategory4,
        ];

        // Prestation data and persisting
        $prestations = [
            [
                'name' => 'Nettoyage à sec costume',
                'picture' => 'costume.jpg',
                'description' => 'Nettoyage à sec professionnel pour costumes.',
                'price' => 1500,
                'category' => 'Vêtements'
            ],
            [
                'name' => 'Repassage chemise',
                'picture' => 'chemise.jpg',
                'description' => 'Service de repassage de chemises.',
                'price' => 500,
                'category' => 'Vêtements'
            ],
            [
                'name' => 'Lavage et pliage',
                'picture' => 'lavage-pliage.jpg',
                'description' => 'Lavage et pliage de vos vêtements.',
                'price' => 1000,
                'category' => 'Vêtements'
            ],
            [
                'name' => 'Nettoyage robe de mariée',
                'picture' => 'robe-mariee.jpg',
                'description' => 'Nettoyage délicat pour robes de mariée.',
                'price' => 3000,
                'category' => 'Vêtements'
            ],
            [
                'name' => 'Nettoyage rideaux',
                'picture' => 'rideaux.jpg',
                'description' => 'Nettoyage de rideaux et tentures.',
                'price' => 2000,
                'category' => 'Linge de maison'
            ],
            [
                'name' => 'Nettoyage tapis',
                'picture' => 'tapis.jpg',
                'description' => 'Nettoyage en profondeur de tapis.',
                'price' => 2500,
                'category' => 'Linge de maison'
            ],
        ];

        // Create prestations with categories
        foreach ($prestations as $data) {
            $prestation = new Prestation();
            $prestation->setName($data['name']);
            $prestation->setPicture($data['picture']);
            $prestation->setDescription($data['description']);
            $prestation->setPrice($data['price']);
            $prestation->setCategory($categories[$data['category']]);

            $manager->persist($prestation);
        }

        // Create articles
        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; $i++) {
                $article = new Article();
                $article->setName('Article ' . $i . ' de ' . $category->getName());
                $article->setDescription('Description de l\'article ' . $i);
                $article->setCategory($category);

                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
