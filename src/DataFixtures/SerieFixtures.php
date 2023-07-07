<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SerieFixtures extends Fixture
{
    public const SERIES = [
        [
            'title' => 'Walking Dead',
            'synopsis' => 'Des zombies envahissent la terre et un groupe essaye de survivre',
            'reference' => 'serie_1'
        ],
        [
            'title' => 'Naruto',
            'synopsis' => 'Un jeune ninja en quête de reconnaissance',
            'reference' => 'serie_2'

        ],
        [
            'title' => 'Breaking Bad',
            'synopsis' => 'Un professeur devient dealer de méthamphétamine',
            'reference' => 'serie_3'

        ],
        [
            'title' => 'Rings Of Power',
            'synopsis' => 'Une elfe veut venger son peuple du mal',
            'reference' => 'serie_4'

        ],
        [
            'title' => 'The Last Of Us',
            'synopsis' => 'Un voyage dans un monde apocalyptique',
            'reference' => 'serie_5'

        ]
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::SERIES as $serieData) {
            $serie = new Serie();
            $serie->setTitle($serieData['title']);
            $serie->setSynopsis($serieData['synopsis']);
            $this->addReference($serieData['reference'], $serie);
            $manager->persist($serie);
        }
        $manager->flush();
    }
}
