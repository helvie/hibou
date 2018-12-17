<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 22/04/2018
 * Time: 16:55
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;
//use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity("email", message="Cet email est déjà utilisé, veuillez en choisir un autre")
 * @UniqueEntity("username", message="Ce nom d'utilisateur est déjà utilisé, veuillez en choisir un autre")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $email;



    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;



    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;


    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * @ORM\Column(type="json")
     */
    private $roles =[];




    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $passwordRequestedAt;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;


    /*
     * Get passwordRequestedAt
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /*
     * Set passwordRequestedAt
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /*
     * Get token
     */
    public function getToken()
    {
        return $this->token;
    }

    /*
     * Set token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }





    public function __construct()
    {
        $this->isActive=true;
    }



    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }


    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }


    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }



    public function getRoles(): array
    {
        $roles = $this->roles;

        if(empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles):void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password));
    }


    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password)
            = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }


}