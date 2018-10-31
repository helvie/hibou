<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 26/04/2018
 * Time: 20:38
 */

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Entity\Comment;
use App\Entity\CommentResponse;
use App\Repository\CommentRepository;
use App\Repository\CommentResponseRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use DateTime;


class ArticleController extends Controller
{

//commentResponseUpdate
//
//commentResponseTrash
//
//commentUpdate
//
//commentTrash

//
//    public function addComment(Request $request, ArticleRepository $articleRepository)
//    {
//
//        $comment = $request->get('art');
//
//    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function articleTrash(Request $request, ArticleRepository $articleRepository)
    {
        $articleId = $request->request->get('articleId');

        $article = $articleRepository -> find($articleId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return new JsonResponse("ok");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function commentTrash(Request $request, CommentRepository $commentRepository,
                                         ArticleRepository $articleRepository)
    {
        $commentId = $request->request->get('commentId');
        $articleId = $request->request->get('articleId');

        $comment = $commentRepository -> find($commentId);
        $article = $articleRepository -> find($articleId);

        $article -> removeComment($comment);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new JsonResponse("ok");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function commentResponseTrash(Request $request, CommentRepository $commentRepository,
                                         CommentResponseRepository $commentResponseRepository)
    {
        $commentId = $request->request->get('commentId');
        $commentResponseId = $request->request->get('commentResponseId');

        $comment = $commentRepository -> find($commentId);
        $commentResponse = $commentResponseRepository -> find($commentResponseId);

        $comment -> removeCommentResponse($commentResponse);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new JsonResponse("ok");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function addComment(Request $request, ArticleRepository $articleRepository, CommentRepository $commentRepository)
    {

        $commentId = $request->request->get('commentId');
        $commentText = $request->request->get('commentText');
        $author = $request->request->get('author');
        $articleId = $request->request->get('articleId');

//        $commentText = "essai";
//        $author = "essai";
//        $commentId = 1;
//        $articleId = 1;

        $article = $articleRepository -> find($articleId);


        if($commentId == 0)
        {
            $comment = new Comment();
            $comment -> setArticle($article);
        }
        else
        {
            $dependantComment = $commentRepository -> find($commentId);
            $comment = new CommentResponse();
            $comment -> setComment($dependantComment);

        }
        $comment -> setAuthor($author);
        $comment -> setText($commentText);
        $comment -> setValid(0);

        $date = new DateTime;
        $comment -> setDate($date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new JsonResponse(array(
            'commentId' => $commentId,
            'commentText' => $commentText,
            'author' => $author,
            'articleId' => $articleId
        ));

    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function articleAdminDisplay(Request $request, ArticleRepository $articleRepository){

        $articles = $articleRepository -> findAll();

        return $this-> render("articleAdmin.html.twig", array
        (
            'articles' => $articles
        ));

    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



    public function articleDisplay(Request $request, ArticleRepository $articleRepository)
    {
        $articleId = $request->query->get('art');

        $article = $articleRepository -> find($articleId);

        return $this->render("article.html.twig", array
        (
            'article' => $article
        )
        );
    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function articleFormDisplay(Request $request, ArticleRepository $articleRepository){

        // Création du formulaire, basé sur une nouvelle entité atelier ponctuel

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleData = $form->getData();

            $date = new DateTime;

            $article -> setDate($date);
            $article -> setUpdateDate($date);
            $article -> setValid(0);

            $entityManager = $this->getDoctrine()->getManager();

            $categories = $articleData -> getCategories();

            foreach($categories as $cat) {
                $article -> getCategories() -> add($cat);
                $cat -> getArticles() -> add($article);
                $entityManager->persist($article);

            }

            $entityManager->persist($article);
            $entityManager->flush();


            return $this->redirectToRoute("articlesAdmin");

        }

        // Affichage du formulaire d'atelier ponctuel

        return $this->render("formArticle.html.twig", array(
            'form' => $form->createView()
        ));

    }

}
