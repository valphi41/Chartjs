<?php

namespace App\DataFixtures;

use App\Entity\Favorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FavoriteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $favorite = new Favorite();
            $favorite->setSerie($this->getReference('serie_' . $faker->numberBetween(1, 5)));
            $favorite->setUser($this->getReference('user_' . $faker->numberBetween(1, 49)));

            $manager->persist($favorite);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SerieFixtures::class,
            UserFixtures::class
        ];
    }
}
