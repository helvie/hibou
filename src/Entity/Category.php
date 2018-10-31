<?php
/**
 * Created by PhpStorm.
 * User: Famille
 * Date: 28/10/2018
 * Time: 19:09
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Validator\Constraints as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="owl_category")
 */
class Category
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 30 caractères")
     */
    private $name;


    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;



    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }


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


    public function addArticle(Article $article)
    {
        $this->articles[]=$article;
    }

    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

    public function getArticles()
    {
        return $this->articles;
    }

}