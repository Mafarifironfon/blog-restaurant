<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class KeywordFixtures extends Fixture
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        $keywords = [
            [
                'name' => 'Familial',
            ],
            [
                'name' => 'Convivial',
            ],
            [
                'name' => 'Charme',
            ],
            [
                'name' => "Insolite",
            ],
            [
                'name' => 'Terasse',
            ],
            [
                'name' => 'Groupe',
            ],
            [
                'name' => 'A emporter'
            ],
            [
                'name' => 'Vue',
            ],
        ];

        foreach ($keywords as $k) {
            $keyword = new Keyword();
            $keyword->setName($k['name']);
            $manager->persist($keyword);
        }

        $manager->flush();
    }
}
