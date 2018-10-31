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
 * @ORM\Entity(repositoryClass="App\Repository\OwlCommentRepository")
 * @ORM\Table(name="owl_comment")
 */
class Comment
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
    private $author;


    /**
     * @Assert\GreaterThan("today")
     * @ORM\Column(type="date")
     */
    private $date;


    /**
     * @ORM\Column(type="string", length=3000)
     * @Assert\Length(min=2,max=3000,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 3000 caractères")
     */
    private $text;


    /**
     * @ORM\ManyToOne(targetEntity="Article" , inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $article;




    /**
     * @ORM\OneToMany(targetEntity="CommentResponse", mappedBy="comment", cascade="all", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $commentResponses;


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




    public function getCategories()
    {
        return $this->categories;
    }


    public function addCategory(Category $category)
    {
        $this->categories[]=$category;
    }

    public function removeOrganism(Category $category)
    {
        $this->categories->removeElement($category);
    }




    public function getText()
    {
        return $this->text;
    }


    public function setText($text)
    {
        $this->text = $text;
    }


    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle(Article $id)
    {
        $this->article = $id;
    }




    public function getCommentResponses()
    {
        return $this->commentResponses;
    }


    public function addCommentResponse(CommentResponse $commentResponse)
    {
        $this->commentResponses[]=$commentResponse;
    }

    public function removeCommentResponse(CommentResponse $commentResponse)
    {
        $this->commentResponses->removeElement($commentResponse);
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