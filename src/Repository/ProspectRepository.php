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


    public function findById($id)
    {
        $query = $this->createQueryBuilder('pro')
            ->where('pro.id = :id')
            ->setParameter('id', $id)
            ->addSelect('pro')
            ->getQuery();

        return $query->getFirstResult();

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

    //----------------------------------------------------------------------------------------------------------


    public function findAllProspects()
    {
        $query = $this->createQueryBuilder('pro')
            ->where('1=1')
            ->leftJoin('pro.prospectInformation', 'inf')
            ->leftJoin('pro.lastAction', 'las')
            ->leftJoin('pro.nextAction', 'nex')
            ->orderBy('pro.nextActionDate')
            ->addSelect('pro', 'las', 'nex')
            ->getQuery();

        return $query->getResult();

    }

}
