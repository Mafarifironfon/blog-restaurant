<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CategoryFixtures extends Fixture
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        $categories = [
            [
                'name' => 'Gastronomique',
            ],
            [
                'name' => 'Bio',
            ],
            [
                'name' => 'Moderne',
            ],
            [
                'name' => "D'ailleurs",
            ],
            [
                'name' => 'Brasserie',
            ],
            [
                'name' => 'Crêperie',
            ],
            [
                'name' => 'Provencal',
            ],
            [
                'name' => 'Vegan',
            ],
        ];

        foreach ($categories as $c) {
            $category = new Category();
            $category->setName($c['name']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
