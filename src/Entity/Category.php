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
use Doctrine\ORM\Mapping\JoinTable;

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


//    /**
//     * @ORM\ManyToMany(targetEntity="Article", inversedBy="categories", orphanRemoval=true)
//     * @JoinTable(name="category_article")
//     */
//    private $articles;

    /**
     * @var \Doctrine\Common\Collections\Collection|Article[]
     *
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="categories")
     */
    protected $articles;
    /**
     * Default constructor, initializes collections
     */

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

//    public function __construct()
//    {
//        $this->articles = new ArrayCollection();
//    }


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


//    public function addArticle(Article $article)
//    {
//        $this->articles[]=$article;
//    }
//
//    public function removeArticle(Article $article)
//    {
//        $this->articles->removeElement($article);
//    }
//
//    public function getArticles()
//    {
//        return $this->articles;
//    }


    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        if ($this->articles->contains($article)) {
            return;
        }
        $this->articles->add($article);
        $article->addCategory($this);
    }
    /**
     * @param Article $article
     */
    public function removeArticle(Article $article)
    {
        if (!$this->articles->contains($article)) {
            return;
        }
        $this->articles->removeElement($article);
        $article->removeCategory($this);
    }
}