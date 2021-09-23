<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getDependencies()
    {
        return [
            KeywordFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        $articles = [
            [
                'title' => 'Les Pins Penchés',
                'description' => "Dans chacune des salles à manger de ce petit Trianon surplombant la mer, ou sur ses terrasses, en été, découvrez la cuisine gastronomique de Stéphane Lelièvre qui met dans votre assiette comme un rayon de soleil. Prenez le temps de flâner dans le parc où les arbres, plusieurs fois centenaires, vous feront ressentir le riche passé des lieux. Votre moment chez nous tiendra autant d'un voyage que d'un simple repas... un instant hors du temps",
                'author' => 'Stéphane Lelievre',
                'image' => '',
            ],
            [
                'title' => 'La Tulipe Noire',
                'description' => "Le seul véritable restaurant déli's de l'aire toulonnaise.Découvrez toute la culture culinaire new yorkaise, en vous évadant le temps d'un café ou d'un breakfast le matin, et d'un repas lors de nos nombreuses soirées à thèmes.Hot dog, véritable baggel du Bronx et burgers vous seront servis depuis La place de la liberté à Toulon.",
                'author' => 'Frédéric Zammit',
                'image' => '',
            ],
            [
                'title' => 'Les Régates',
                'description' => "Le restaurant Les Régates de Toulon est idéalement situé sur le port de Toulon, face au Mont Faron. Venez profitez en famille ou pour vos repas d'affaires de sa salle panoramique climatisée ou de son balcon terrasse.",
                'author' => 'Stéphane Lelievre',
                'image' => '',
            ],
            [
                'title' => "Les Têtes d'Ail",
                'description' => "Restaurant bar dans le centre ville de Toulon (place de la poissonnerie, derrière la mairie) avec une terrasse couverte chauffée l'hiver et une terrasse ombragée sous les oliviers de la place l' été. Fraicheur provençale et apéro convivial !",
                'author' => 'Olivia Roudeix',
                'image' => '',
            ],
            [
                'title' => 'Tables et Comptoir',
                'description' => "Maître Restaurateur Varois, Serge VAZ privilégie les produits frais, Français, l'agriculture paysanne et biologique,le label rouge et les AOC...pêche méditerranéenne, viandes fermières...pour une véritable et savoureuse cuisine maison...jusqu'au pain",
                'author' => 'Serge Vaz',
                'image' => '',
            ],
        ];

        foreach ($articles as $a) {
            $article = new Article();
            $article->setTitle($a['title']);
            $article->setDescription($a['description']);
            $article->setAuthor($a['author']);
            $article->setCreationDate($faker->dateTime());
            $article->setImage($a['image']);
            $article->setCategory($faker->randomElement($array = $this->em->getRepository(Category::class)->findAll()));
            $article->addKeyword($faker->randomElement($array = $this->em->getRepository(Keyword::class)->findAll()));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
