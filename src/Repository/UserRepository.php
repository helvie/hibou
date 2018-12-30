<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 27/04/2018
 * Time: 21:11
 */

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Serializer\Mapping\ClassMetadata;




class UserRepository extends EntityRepository implements UserLoaderInterface
{

//    // Constructor for autowiring
//    public function __construct(UserLoaderInterface $em)
//    {
//        parent::__construct($em, $em->getClassMetadata(User::class));
//    }


    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => User::class,
        ]);
    }
}