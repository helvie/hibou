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
 * @ORM\Entity(repositoryClass="App\Repository\Prospect")
 * @ORM\Table(name="owl_prospect")
 */
class Prospect
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;


    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min=2,max=100,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 100 caractères")
     */

    private $name;


    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */

    private $email;


    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "Veuillez entrer 10 chiffres exactement",
     *      maxMessage = "Veuillez entrer 10 chiffres exactement",
     *      exactMessage = "Veuillez entrer 10 chiffres exactement"
     * )
     */

    private $phone;


    /**
     * @ORM\OneToOne(targetEntity="ProspectInformation", cascade="persist", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */

    private $prospectInformation;


    /**
     * @ORM\Column(type="boolean")
     */

    private $quoteRequest;


    /**
     * @ORM\Column(type="boolean")
     */

    private $newsletterRequest;


    /**
     * @ORM\Column(type="boolean")
     */

    private $informationsRequest;


    /**
     * @ORM\Column(type="boolean")
     */

    private $archived;

    /**
     * @ORM\ManyToOne(targetEntity="ProspectLastAction", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */

    private $lastAction;


    /**
     * @Assert\GreaterThan("today")
    * @ORM\Column(type="date")
    */

    private $lastActionDate;


    /**
     * @ORM\ManyToOne(targetEntity="ProspectNextAction", cascade="persist", inversedBy="prospects")
     * @ORM\JoinColumn(nullable=true)
     */

    private $nextAction;


    /**
     * @Assert\GreaterThanOrEqual("today")
     * @ORM\Column(type="date")
     */

    private $nextActionDate;

    /**
     * @ORM\Column(type="integer")
     */

    private $applicant;


    /**
     * @ORM\Column(type="text", nullable=true)
     */

    private $information;



    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpd;


    public function getId()
    {
        return $this->id;
    }



    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
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



    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    /**
     * @return mixed
     */
    public function getProspectInformation()
    {
        return $this->prospectInformation;
    }


    /**
     * @param mixed $prospectInformation
     */
    public function setProspectInformation(ProspectInformation $prospectInformation)
    {
        $this->prospectInformation = $prospectInformation;
    }


    public function getQuoteRequest()
    {
        return $this->quoteRequest;
    }


    public function setQuoteRequest($quoteRequest)
    {
        $this->quoteRequest = $quoteRequest;
    }


    public function getNewsletterRequest()
    {
        return $this->newsletterRequest;
    }


    public function setNewsletterRequest($newsletterRequest)
    {
        $this->newsletterRequest = $newsletterRequest;
    }


    public function getInformationsRequest()
    {
        return $this->informationsRequest;
    }


    public function setInformationsRequest($informationsRequest)
    {
        $this->informationsRequest = $informationsRequest;
    }


    public function getArchived()
    {
        return $this->archived;
    }


    public function setArchived($archived)
    {
        $this->archived = $archived;
    }


    public function getLastAction()
    {
        return $this->lastAction;
    }

    public function setLastAction(ProspectLastAction $lastAction)
    {
        $this->lastAction = $lastAction;
    }


    public function getLastActionDate()
    {
        return $this->lastActionDate;
    }


    public function setLastActionDate($lastActionDate)
    {
        $this->lastActionDate = $lastActionDate;
    }


    public function getNextAction()
    {
        return $this->nextAction;
    }


    public function setNextAction(ProspectNextAction $nextAction)
    {
        $this->nextAction = $nextAction;
    }


    public function getNextActionDate()
    {
        return $this->nextActionDate;
    }


    public function setNextActionDate($nextActionDate)
    {
        $this->nextActionDate = $nextActionDate;
    }

    public function getApplicant()
    {
        return $this->applicant;
    }


    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;
    }

    public function getInformation()
    {
        return $this->information;
    }

    public function setInformation($information)
    {
        $this->information = $information;
    }




    /**
     * @return mixed
     */
    public function getRgpd()
    {
        return $this->rgpd;
    }

    /**
     * @param mixed $rgpd
     */
    public function setRgpd($rgpd): void
    {
        $this->rgpd = $rgpd;
    }

}