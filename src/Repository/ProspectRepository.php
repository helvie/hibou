<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 22/04/2018
 * Time: 16:58
 */

namespace App\Repository;

use App\Entity\Prospect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class ProspectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prospect::class);
    }




    //----------------------------------------------------------------------------------------------------------


    public function findByEmail($email)
    {
        $query = $this->createQueryBuilder('pro')
            ->where('pro.email = :email')
            ->setParameter('email', $email)
            ->addSelect('pro')
            ->getQuery();

        return $query->getFirstResult();

    }

}
