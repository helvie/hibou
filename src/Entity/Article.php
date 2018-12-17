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
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=2,max=30,minMessage="Veuillez saisir 2 caractères minimum", maxMessage="Veuillez saisir un maximum de 30 caractères")
     */
    private $role;




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



//    /**
//     * @ORM\ManyToMany(targetEntity="Category", mappedBy="articles", orphanRemoval=true)
//     * @JoinTable(name="category_article")
//     */
//    private $categories;


    /**
     * @ORM\Column(type="string", length=16000)
     * @Assert\Length(min=2,max=16000,minMessage="Veuillez saisir 2 caractères minimum ", maxMessage="Veuillez saisir un maximum de 16000 caractères")
     */
    private $text;


//    /**
//     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade="all", orphanRemoval=true)
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;


    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\File(
    mimeTypes={"image/jpeg", "image/png", "image/jpg"}, maxSize = "300k", maxSizeMessage = "Veuillez choisir une image de moins de 300 ko",  mimeTypesMessage = "Veuillez choisir un fichier de format Jpeg ou PNG")
     */
    private $authorImage;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\File(
    mimeTypes={"image/jpeg", "image/png", "image/jpg"}, maxSize = "300k", maxSizeMessage = "Veuillez choisir une image de moins de 300 ko",  mimeTypesMessage = "Veuillez choisir un fichier de format Jpeg ou PNG")
     */
    private $articleImage;


    /**
     * @var \Doctrine\Common\Collections\Collection|Category[]
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinTable(
     *  name="article_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $categories;


    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }


//    public function __construct()
//    {
//
//        $this->categories = new ArrayCollection();
//
//    }



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



    public function getRole()
    {
        return $this->role;
    }


    public function setRole($role)
    {
        $this->role = $role;
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


//
//    public function getCategories()
//    {
//        return $this->categories;
//    }
//
//
//    public function addCategory(Category $category)
//    {
//        $this->categories[]=$category;
//    }
//
//    public function removeCategory(Category $category)
//    {
//        $this->categories->removeElement($category);
//    }



    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            return;
        }
        $this->categories->add($category);
        $category->addArticle($this);
    }
    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }
        $this->categories->removeElement($category);
        $category->removeArticle($this);
    }

//    public function getComments()
//    {
//        return $this->comments;
//    }
//
//
//    public function addComment(Comment $comment)
//    {
//        $this->comments[]=$comment;
//    }
//
//    public function removeComment(Comment $comment)
//    {
//        $this->comments->removeElement($comment);
//    }



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


    public function getAuthorImage()
    {
        return $this->authorImage;
    }


    public function setAuthorImage($authorImage)
    {
        $this->authorImage = $authorImage;

        return $this;
    }


    public function getArticleImage()
    {
        return $this->articleImage;
    }


    public function setArticleImage($articleImage)
    {
        $this->articleImage = $articleImage;

        return $this;
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