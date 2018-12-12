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
 * @ORM\Entity(repositoryClass="App\Repository\ProspectNextAction")
 * @ORM\Table(name="prospect_next_action")
 */
class ProspectNextAction
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

    private $action;


    /**
     * @ORM\OneToMany(targetEntity="Prospect", mappedBy="nextAction", cascade="all")
     * @ORM\JoinColumn(nullable=true)
     */
    private $prospects;



    public function getId()
    {
        return $this->id;
    }



    public function getAction()
    {
        return $this->action;
    }


    public function setAction($action)
    {
        $this->action = $action;
    }


    public function __construct()
    {
        $this->prospects = new ArrayCollection();
    }

    public function getProspects()
    {
        return $this->prospects;
    }

}