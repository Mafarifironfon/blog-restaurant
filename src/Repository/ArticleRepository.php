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
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.keywords', 'k');

        if (array_key_exists('keyword', $filters) && ($filters['keyword']) !== null) {
            $where ='a.id IS NULL';
            $where .= ' OR a.title LIKE :title OR a.description LIKE :description OR a.author LIKE :auhtor OR k.name LIKE :keyword';
            $qb->andWhere($where)
                ->setParameter('title', '%'.ArticleHandler::cleanString($filters['keyword']).'%')
                ->setParameter('description', '%'.ArticleHandler::cleanString($filters['keyword']).'%')
                ->setParameter('auhtor', '%'.ArticleHandler::cleanString($filters['keyword']).'%')
                ->setParameter('keyword', '%'.ArticleHandler::cleanString($filters['keyword']).'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findArticleByCategory($filters)
    {
        $qb = $this->createQueryBuilder('a')
        ->leftJoin('a.category', 'c');

        if (array_key_exists('category', $filters) && ($filters['category']) !== null) {
            $qb->where('c.name = :name')
                ->setParameter('name',  $filters['category']);
        }

        return $qb->getQuery()->getResult();
    }
}
