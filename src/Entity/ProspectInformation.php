<?php
/**
 * Created by PhpStorm.
 * User: Famille
 * Date: 09/12/2018
 * Time: 19:09
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Validator\Constraints as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProspectInformation")
 * @ORM\Table(name="prospect_information")
 */

class ProspectInformation
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;


    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=2,max=100,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 100 caractères")
     */

    private $company;

    /**
     * @ORM\Column(type="integer")
     */

    private $respCivility;

    /**
     * @ORM\Column(type="text", nullable = false)
     * @Assert\Regex(pattern = "/^[a-zA-Z]+$/", message = "Veuillez entrer un nom valide")
     * @Assert\Length(min=2,max=20,minMessage="Veuillez saisir un minimum de 2 caractères ", maxMessage="Veuillez saisir un maximum de 20 caractères")
     */

    private $respName;



    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */

    private $email;


    /**
     * @ORM\Column(name="siret", type="string")
     * @Assert\Length(
     *      min = 14,
     *      max = 14,
     *      minMessage = "Veuillez entrer 14 chiffres exactement",
     *      maxMessage = "Veuillez entrer 14 chiffres exactement",
     *      exactMessage = "Veuillez entrer 14 chiffres exactement"
     * )
     */

    private $siret;


    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=2,max=100,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 100 caractères")
     */

    private $activity;



    /**
     * @ORM\Column(type="integer", length=5)
     */
    private $postalCode;



    /**
     * @ORM\Column(type="string", length=100)
     */
    private $locality;



    public function getId()
    {
        return $this->id;
    }



    public function getCompany()
    {
        return $this->company;
    }


    public function setCompany($company)
    {
        $this->company = $company;
    }


    public function getRespCivility()
    {
        return $this->respCivility;
    }


    public function setRespCivility($respCivility)
    {
        $this->respCivility = $respCivility;
    }


    public function getRespName()
    {
        return $this->respName;
    }


    public function setRespName($respName)
    {
        $this->respName = $respName;
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



    public function getActivity()
    {
        return $this->activity;
    }


    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    public function getSiret()
    {
        return $this->siret;
    }


    public function setSiret($siret)
    {
        $this->siret = $siret;
    }




    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }


    /**
     * @return mixed
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param mixed $locality
     */
    public function setLocality($locality): void
    {
        $this->locality = $locality;
    }

}