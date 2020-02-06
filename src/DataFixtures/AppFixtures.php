<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{


    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $product = new Product();
        

        for ($i = 1; $i <= 100; ++$i) {
            $product = new Product();
            $product->setNom('iPhone '.$i);
            $product->setSlug($this->slugger->slug($product->getNom())->lower());
            $product->setDescription($faker->text);
            $product->setPrix(rand(10, 1000) * 100);
            #$product->setDate($faker->date($format = 'Y-m-d', $max = 'now'));
            $product->setDate($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
            $product->setCoupdecoeur(rand(0, 1));
            $product->setCouleur([
                'Rouge',
                'Noir',
                'Blanc'
            ]);
            $product->setPromo(rand(0,50));
            $manager->persist($product);
        }

        $manager->persist($product);

        $manager->flush();
    }
}
