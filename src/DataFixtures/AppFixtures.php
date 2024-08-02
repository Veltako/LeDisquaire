<?php

namespace App\DataFixtures;

use App\Entity\Chanteur;
use App\Entity\Disque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        $listChanteur = [];

        for ($i = 0; $i <= 10; $i++) {
            $chanteur = new Chanteur();
            $chanteur->setNom($this->faker->firstName());
            $manager->persist($chanteur);

            $listChanteur[] = $chanteur;
        }

        for ($i = 0; $i <= 20; $i++) {
            $disque = new Disque();
            $disque->setNomDisque($this->faker->sentence());
            $disque->setChanteur($listChanteur[array_rand($listChanteur)]);

            $manager->persist($disque);
        }


        $manager->flush();
    }
}
