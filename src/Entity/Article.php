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
 * @ORM\Entity(repositoryClass="App\Repository\OwlArticleRepository")
 * @ORM\Table(name="owl_article")
 */
class Article
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
    private $title;


    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 30 caractères")
     */
    private $author;


    /**
     * @Assert\GreaterThan("today")
     * @ORM\Column(type="date")
     */
    private $date;


    /**
     * @Assert\GreaterThan("today")
     * @ORM\Column(type="date")
     */
    private $updateDate;


    /**
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="articles", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;


    /**
     * @ORM\Column(type="string", length=3000)
     * @Assert\Length(min=2,max=3000,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 3000 caractères")
     */
    private $text;


    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade="all", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;


    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;


    public function __construct()
    {

        $this->categories = new ArrayCollection();

    }



    public function getId()
    {
        return $this->id;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }



    public function getAuthor()
    {
        return $this->author;
    }


    public function setAuthor($author)
    {
        $this->author = $author;
    }



    public function getDate()
    {
        return $this->date;
    }


    public function setDate($date)
    {
        $this->date = $date;
    }



    public function getUpdateDate()
    {
        return $this->updateDate;
    }


    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    }



    public function getCategories()
    {
        return $this->categories;
    }


    public function addCategory(Category $category)
    {
        $this->categories[]=$category;
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }



    public function getComments()
    {
        return $this->comments;
    }


    public function addComment(Comment $comment)
    {
        $this->comments[]=$comment;
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }



    public function getText()
    {
        return $this->text;
    }


    public function setText($text)
    {
        $this->text = $text;
    }



    public function getVisible()
    {
        return $this->visible;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }



    public function getValid()
    {
        return $this->valid;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }
}