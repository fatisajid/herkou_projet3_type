<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= mt_rand(8,10); $i++)
        {
            $produit = new Produit;
             
            $produit->setTitre($faker->sentence(3, false))
                    ->setPhoto($faker->photoUrl)
                    ->setPrix($faker->randomFloat(2,10,100));

 $manager->persist($produit);

        }

        $manager->flush();
    }
}
