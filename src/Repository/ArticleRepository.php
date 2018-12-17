<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 22/04/2018
 * Time: 16:58
 */

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }




    //----------------------------------------------------------------------------------------------------------


    public function findArticleById($id)
    {
        $query = $this->createQueryBuilder('art')
            ->leftJoin('art.categories', 'cat')
            ->where('art.id = :id')
            ->setParameter('id', $id)
            ->addSelect('art', 'cat')
            ->getQuery();

        return $query->getOneOrNullResult();

    }
    //----------------------------------------------------------------------------------------------------------


    public function findAllArticles()
    {
        $query = $this->createQueryBuilder('art')
            ->leftJoin('art.categories', 'cat')
            ->where('1 = 1')
            ->addSelect('art', 'cat')
            ->getQuery();

        return $query;

    }
}
