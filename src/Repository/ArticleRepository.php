<?php

namespace App\Repository;

use App\Entity\Article;
use App\Service\ArticleHandler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findArticleByFilters($filters)
    {
        $qb = $this->createQueryBuilder('a');

        if (array_key_exists('keyword', $filters) && ($filters['keyword']) !== null) {
            $qb->andWhere('a.title LIKE :ft')
                ->setParameter('ft', '%'.ArticleHandler::cleanString($filters['keyword']).'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findArticleByCategory($filters)
    {
        $qb = $this->createQueryBuilder('a')
        ->leftJoin('a.category', 'c');

        if (array_key_exists('name', $filters) && ($filters['name']) !== null) {
            $qb->where('c.name = :name')
                ->setParameter('name',  $filters['name']);
        }

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
