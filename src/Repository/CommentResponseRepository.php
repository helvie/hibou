<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 22/04/2018
 * Time: 16:58
 */

namespace App\Repository;

use App\Entity\CommentResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class CommentResponseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentResponse::class);
    }




    //----------------------------------------------------------------------------------------------------------


//    public function findCat($id)
//    {
//        $query = $this->createQueryBuilder('orp')
//            ->where('orp.id = :id')
//            ->setParameter('id', $id)
//            ->addSelect('orp')
//            ->getQuery();
//
//        return $query;
//
//    }

}
