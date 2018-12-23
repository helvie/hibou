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
use App\Entity\Prospect;
use App\Entity\ProspectInformation;
use App\Repository\LastActionRepository;
use App\Repository\NextActionRepository;
use App\Repository\ProspectRepository;
use App\Form\ProspectType;
use App\Form\ProspectInformationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use DateInterval;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;


class DefaultController extends Controller
{


//    public function owlHomeDisplay(Request $request, ArticleRepository $articleRepository)
//    {
//
//        return $this-> render("owlHome.html.twig");
//
////    }
//    public function nextActionSave(Request $request, ProspectRepository $prospectRepository, NextActionRepository
//    $nextActionRepository){
//
//
//        $prospect=$prospectRepository->findById(11);
//
//        return $this-> render("essai.html.twig", array
//        (
//            'data' => $prospect
//        ));
//
//
//    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Création d'un nom unique de fichier~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps

        return md5(uniqid());
    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlReferencesDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlReferences.html.twig");

    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlAgencyDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlAgency.html.twig");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlServicesDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlServices.html.twig");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlBlogDisplay(Request $request, ArticleRepository $articleRepository)
    {

        $articles = $articleRepository -> findAllArticles()->getArrayResult();

        $latestArticle = end($articles);
        $latestArticleId = $latestArticle["id"];

        $var = 1;
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $articleArray=[];

        foreach ($articles as &$value) {
            if ($var == 1) {
                array_push($array1, $value);
                $var=2;
            }
            else if($var==2) {
                array_push($array2, $value);
                $var=3;
            }
            else if($var==3){
                array_push($array3, $value);
                $var=1;
            }
        }

        array_push($articleArray, $array1);
        array_push($articleArray, $array2);
        array_push($articleArray, $array3);
        array_push($articleArray, $articles);






        return $this-> render("owlBlog.html.twig", array
        (

            'articles' => $articleArray,
            'latestArticleId' => $latestArticleId
        ));

    }


//    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
////~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
////~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//
//    public function adminArticleDisplay(Request $request, ArticleRepository $articleRepository){
//
//        $articles = $articleRepository -> findAll();
//
//        return $this-> render("adminArticle.html.twig", array
//        (
//            'articles' => $articles
//        ));
//
//    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlContactDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlContact.html.twig");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlHomeDisplay(Request $request, ProspectRepository $prospectRepository, LastActionRepository $lastActionRepository, NextActionRepository $nextActionRepository)
    {

        $cardsArray = array("1blue", "2blue", "1green", "2green", "1pink", "2pink", "1red", "2red", "1yellow", "2yellow", "1owl", "2owl");

        shuffle($cardsArray);

        $formProspect = new Prospect();

        $formNL = $this->createForm(ProspectType::class, $formProspect);

        $formNL->handleRequest($request);

        $today = new dateTime();
        $today2 = $today -> format('d/m/Y');
        $today15 = new dateTime();
        $today15 -> add(new DateInterval('P15D'));

        if ($formNL->isSubmitted() && $formNL->isValid()) {

            $existingProspect = $prospectRepository->findOneByEmail($formProspect -> getEmail());

            $lastAction = $lastActionRepository -> find(1);
            $nextAction = $nextActionRepository -> find(4);

            if($existingProspect != null){
                $thisProspect = $existingProspect;
                $quote = $thisProspect -> getQuoteRequest();
                $infos = $thisProspect -> getInformationsRequest();
                $information = $thisProspect -> getInformation();
            }

            else{
                $thisProspect = new Prospect();
                $quote = "0";
                $infos = "0";
                $information = "";
            }
            $thisProspect->setName($formProspect -> getName());
            $thisProspect->setEmail($formProspect -> getEmail());
            $thisProspect->setQuoteRequest($quote);
            $thisProspect->setNewsletterRequest(1);
            $thisProspect->setInformationsRequest($infos);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction($lastAction);
            $thisProspect->setLastActionDate($today);
            $thisProspect->setNextAction($nextAction);
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($today15);
            $thisProspect -> setInformation("<p>".$today2." - Inscription à la newsletter</p><p></p>".$information);

            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->flush();

            // Redirection vers le formulaire d'activité

            return $this->redirectToRoute('index');

        }

        // Affichage du formulaire d'activité

        return $this->render('owlHome.html.twig', [
            'formNL' => $formNL->createView(),
            "cardsArray" => $cardsArray,

        ]);

    }





//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function formContactDisplay(Request $request, ProspectRepository $prospectRepository, LastActionRepository
                                        $lastActionRepository, NextActionRepository $nextActionRepository)
    {

        $formContactRequest = new Prospect();
        $formRequest = $this->createForm(ProspectType::class, $formContactRequest);
        $formRequest->handleRequest($request);

        $formProspectInfo = new ProspectInformation();
        $formQuote = $this->createForm(ProspectInformationType::class, $formProspectInfo);
        $formQuote->handleRequest($request);

        $today = new dateTime();
        $today2 = $today -> format('d/m/Y');

        if ($formRequest->isSubmitted() && $formRequest->isValid()) {

            $existingProspect = $prospectRepository->findOneByEmail($formContactRequest -> getEmail());

            if($existingProspect != null){
                $thisProspect = $existingProspect;
                $quote = $thisProspect -> getQuoteRequest();
                $NL = $thisProspect -> getNewsletterRequest();
                $information = $thisProspect -> getInformation();
            }

            else{
                $thisProspect = new Prospect();
                $quote = "0";
                $NL = "0";
                $information = "";
            }

            $lastAction = $formContactRequest -> getLastAction();
            $nextAction = $formContactRequest -> getNextAction();
            $newMessage = $formContactRequest -> getInformation();

            $thisProspect->setName($formContactRequest -> getName());
            $thisProspect->setEmail($formContactRequest -> getEmail());
            $thisProspect->setQuoteRequest($quote);
            $thisProspect->setNewsletterRequest($NL);
            $thisProspect->setInformationsRequest(1);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction($lastAction);
            $thisProspect->setLastActionDate($today);
            $thisProspect->setNextAction($nextAction);
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($formContactRequest -> getNextActionDate());
            $thisProspect->setPhone($formContactRequest -> getPhone());

            if ($lastAction == $lastActionRepository -> find(12)) {$message = $today2." - Rendez-vous téléphonique demandé le ".
                $formContactRequest -> getNextActionDate()-> format('d/m/Y')." (".$nextAction->getAction()."). Message laissé : '".$newMessage."'";}

            else if ($lastAction == $lastActionRepository -> find(11)) {$message = $today2." - Informations demandées par mail. Message laissé : '"
                .$newMessage."'";}

            $thisProspect -> setInformation("<p>".$message."</p><p></p>".$information);

            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->flush();

            return $this->render('owlReferences.html.twig', array('essai' => $formContactRequest));

    }


        if ($formQuote->isSubmitted() && $formQuote->isValid()) {

            $existingProspect = $prospectRepository->findOneByEmail($formProspectInfo -> getProspect() -> getEmail());

            if($existingProspect != null){

                $thisProspect = $existingProspect;
                $NL = $thisProspect -> getNewsletterRequest();
                $information = $thisProspect -> getInformation();
                $infos = $thisProspect -> getInformationsRequest();


                if($thisProspect -> getProspectInformation() !=null){
                    $thisProspectInformation = $thisProspect -> getProspectInformation();
                }

                else {
                    $thisProspectInformation = new ProspectInformation();
                }
            }
            else
            {
                $thisProspect = new Prospect();
                $thisProspectInformation = new ProspectInformation();
                $NL = 0;
                $infos = 0;
                $information = "";

            }

            $newMessage = $formProspectInfo -> getProspect() -> getInformation();

            $thisProspect -> setName($formProspectInfo -> getCompany());
            $thisProspect -> setEmail($formProspectInfo -> getProspect() -> getEmail());
            $thisProspect -> setPhone($formProspectInfo -> getProspect()  -> getPhone());
            $thisProspect->setQuoteRequest(1);
            $thisProspect->setNewsletterRequest($NL);
            $thisProspect->setInformationsRequest($infos);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction($lastActionRepository -> find(2));
            $thisProspect->setLastActionDate($today);
            $thisProspect->setNextAction($nextActionRepository -> find(5));
            //Demandeur : 1-prospect, 2-commercial, 3-automatique
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($today);
            $thisProspect->setInformation("<p>".$today2." - Demande de devis - Message : ".$newMessage."</p><p></p>".$information);

            $thisProspectInformation -> setCompany($formProspectInfo -> getCompany());
//            $thisProspectInformation -> setEmail($formProspectInfo -> getEmail());
//            $thisProspectInformation -> setPhone($formProspectInfo -> getPhone());
            $thisProspectInformation -> setRespCivility($formProspectInfo -> getRespCivility());
            $thisProspectInformation -> setRespName($formProspectInfo -> getRespName());
            $thisProspectInformation -> setSiret($formProspectInfo -> getSiret());
            $thisProspectInformation -> setActivity($formProspectInfo -> getActivity());
            $thisProspectInformation -> setRoute($formProspectInfo -> getRoute());
            $thisProspectInformation -> setPostalCode($formProspectInfo -> getPostalCode());
            $thisProspectInformation -> setLocality($formProspectInfo -> getLocality());

            $thisProspect -> setProspectInformation($thisProspectInformation);
            $thisProspectInformation -> setProspect($thisProspect);


            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->persist($thisProspectInformation);
            $em->flush();


            return $this->render('owlHome.html.twig', array("this" => $thisProspect, "existingProspect" => $NL));

        }






        return $this->render('owlContact.html.twig',
            array(
                'formContactDisplay' => $formRequest->createView(),
                'formQuote' => $formQuote->createView()

    )
        );
}



    public function formContactDisplay2(Request $request, ProspectRepository $prospectRepository)
    {

        // Création du formulaire avec une nouvelle entité

        $formProspect = new Prospect();
        $formProspectInfo = new ProspectInformation();
        $formContactRequest = new Prospect();

        $formNL = $this->createForm(ProspectType::class, $formProspect);

        $formQuote = $this->createForm(ProspectInformationType::class, $formProspectInfo);

        $formRequest = $this->createForm(ProspectType::class, $formContactRequest);


        $formNL->handleRequest($request);
        $formQuote->handleRequest($request);
        $formRequest->handleRequest($request);

        $today = new dateTime();
        $today2 = $today -> format('d/m/Y');
        $today15 = new dateTime();
        $today15 -> add(new DateInterval('P15D'));

        if ($formRequest->isSubmitted() && $formNL->isValid()) {
            $existingProspect = $prospectRepository->findOneByEmail($formProspect -> getEmail());

            if($existingProspect != null){
                $thisProspect = $existingProspect;
                $quote = $thisProspect -> getQuoteRequest();
                $NL = $thisProspect -> getNewsletterRequest();
                $information = $thisProspect -> getInformation();
            }
            else{
                $thisProspect = new Prospect();
            }

            $thisProspect->setQuoteRequest($quote);
            $thisProspect->setNewsletterRequest($NL);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction($formContactRequest->getLastAction());
            $thisProspect->setLastActionDate($today);
            if($formContactRequest->getLastAction()==12)
                {
                    $thisProspect->setNextAction(6);
                }
            elseif($formContactRequest->getLastAction()==13)
                {
                    $thisProspect->setNextAction(1);

                }
            //Demandeur : 1-prospect, 2-commercial, 3-automatique
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($today15);
            $thisProspect -> setInformation($information."<p><b>Inscription à la newsletter - ".$today2."</b></p>");

            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->flush();

            // Redirection vers le formulaire d'activité

            return $this->redirectToRoute('index');

        }




        if ($formNL->isSubmitted() && $formNL->isValid()) {

            $existingProspect = $prospectRepository->findOneByEmail($formProspect -> getEmail());

            if($existingProspect != null){
                $thisProspect = $existingProspect;
                $quote = $thisProspect -> getQuoteRequest();
                $NL = $thisProspect -> getNewsletterRequest();
                $information = $thisProspect -> getInformation();
            }

            else{
                $thisProspect = new Prospect();
            }

            $thisProspect->setQuoteRequest($quote);
            $thisProspect->setNewsletterRequest(1);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction(1);
            $thisProspect->setLastActionDate($today);
            $thisProspect->setNextAction(4);
            //Demandeur : 1-prospect, 2-commercial, 3-automatique
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($today15);
            $thisProspect -> setInformation($information."<p><b>Inscription à la newsletter - ".$today2."</b></p>");

            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->flush();

            // Redirection vers le formulaire d'activité

            return $this->redirectToRoute('index');

        }

        if ($formQuote->isSubmitted() && $formQuote->isValid()) {

            $existingProspect = $prospectRepository->findOneByEmail($formProspectInfo -> getEmail());

            if($existingProspect != null){

                $thisProspect = $existingProspect;
                $NL = $thisProspect -> getNewsletterRequest();
                $information = $thisProspect -> getInformation();


                if($thisProspect -> getProspectInformation() !=null){
                    $thisProspectInformation = $thisProspect -> getProspectInformation();
                }

                else {
                    $thisProspectInformation = new ProspectInformation();
                }
            }
            else
            {
                $thisProspect = new Prospect();
                $thisProspectInformation = new ProspectInformation();
                $NL = 0;
                $information = "";

            }

            $thisProspect -> setName($formProspectInfo -> getCompany());
            $thisProspect -> setEmail($formProspectInfo -> getEmail());
            $thisProspect->setQuoteRequest(1);
            $thisProspect->setNewsletterRequest($NL);
            $thisProspect->setInformationsRequest(0);
            $thisProspect->setArchived(0);
            $thisProspect->setLastAction(2);
            $thisProspect->setLastActionDate($today);
            $thisProspect->setNextAction(2);
            $thisProspect->setNextActionDate($today15);
            //Demandeur : 1-prospect, 2-commercial, 3-automatique
            $thisProspect->setApplicant(1);
            $thisProspect->setNextActionDate($today);
            $thisProspect->setInformation($information."<p><b>Demande de devis - ".$today2."</b></p>");

            $thisProspectInformation -> setCompany($formProspectInfo -> getCompany());
            $thisProspectInformation -> setEmail($formProspectInfo -> getEmail());
            $thisProspectInformation -> setRespCivility($formProspectInfo -> getRespCivility());
            $thisProspectInformation -> setRespName($formProspectInfo -> getRespName());
            $thisProspectInformation -> setSiret($formProspectInfo -> getSiret());
            $thisProspectInformation -> setActivity($formProspectInfo -> getActivity());
            $thisProspectInformation -> setPhone($formProspectInfo -> getPhone());
            $thisProspectInformation -> setPostalCode($formProspectInfo -> getPostalCode());
            $thisProspectInformation -> setLocality($formProspectInfo -> getLocality());

            $thisProspect -> setProspectInformation($thisProspectInformation);



            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->persist($thisProspectInformation);
            $em->flush();


            return $this->render('owlHome.html.twig', array("this" => $thisProspect, "existingProspect" => $NL));

        }

        // Affichage du formulaire d'activité

        return $this->render('owlContact.html.twig', [
            'formNL' => $formNL->createView(),
            'formQuote' => $formQuote->createView()
        ]);

    }



    public function essai(Request $request, ArticleRepository $articleRepository)
    {

        $cardsArray = array("1blue", "2blue", "1green", "2green", "1pink", "2pink", "1red", "2red", "1yellow", "2yellow", "1owl", "2owl");




        shuffle($cardsArray);


        return $this-> render("essai.html.twig", array(
            "cardsArray" => $cardsArray,
        ));

    }

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

    public function adminArticleDisplay(Request $request, ArticleRepository $articleRepository){

        $articles = $articleRepository -> findAll();

        return $this-> render("adminArticle.html.twig", array
        (
            'articles' => $articles
        ));

    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function nextActionSave(Request $request, ProspectRepository $prospectRepository, NextActionRepository
    $nextActionRepository){

        $today = new dateTime();
        $today2 = $today -> format('d/m/Y');
//
        $prospectId = $request->request->get("prospectId");
        $prospectId = substr($prospectId,2);

        $nextActionId = $request->request->get("nextActionId");
        $nextActionArea = $request->request->get("nextActionArea");


        $nextFullActionDate = $request->request->get("nextFullActionDate");
        $day=substr($nextFullActionDate, 0,2);
        $month=substr($nextFullActionDate, 3,2);
        $year=substr($nextFullActionDate, 6);
        $date=new DateTime($month."/".$day."/".$year);

        $prospect=$prospectRepository->find($prospectId);

        $nextAction = $nextActionRepository->find($nextActionId);
        $nextActionText = $nextAction->getAction();

        $prospectInfo = $prospect->getInformation();
        $message = "<p>".$today2." - ".$nextActionText.", le ".$nextFullActionDate." - Note : ".$nextActionArea."</p><p></p>".$prospectInfo;

        $prospect->setNextActionDate($date);
        $prospect->setNextAction($nextAction);
        $prospect->setInformation($message);


        $em = $this->getDoctrine()->getManager();
        $em->persist($prospect);
        $em->flush();

        $data=$prospect->getId();
        return new JsonResponse($data);

    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function lastActionSave(Request $request, ProspectRepository $prospectRepository, LastActionRepository
    $lastActionRepository){

        $today = new dateTime();
        $today2 = $today -> format('d/m/Y');

        $prospectId = $request->request->get("prospectId");
        $prospectId = substr($prospectId,2);
////
        $lastActionId = $request->request->get("lastActionId");
        $lastActionArea = $request->request->get("lastActionArea");
//////
        $prospect=$prospectRepository->find($prospectId);
////
        $lastAction = $lastActionRepository->find($lastActionId);
        $lastActionText = $lastAction->getAction();
//
        $prospectInfo = $prospect->getInformation();
        $message = "<p>".$today2." - ".$lastActionText." - Note : ".$lastActionArea."</p><p></p>".$prospectInfo;
//
        $prospect->setLastActionDate($today);
        $prospect->setLastAction($lastAction);
        $prospect->setInformation($message);
//
        $em = $this->getDoctrine()->getManager();
        $em->persist($prospect);
        $em->flush();
//
        return new JsonResponse($prospect->getId());


    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public function adminProspectDisplay(Request $request, ProspectRepository $prospectRepository){

        $prospects = $prospectRepository -> findAllProspects();

        return $this-> render("adminProspect.html.twig", array
        (
            'prospects' => $prospects
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


    public function articleFormDisplay(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {

        // Création du formulaire, basé sur une nouvelle entité atelier ponctuel

        if ($request->query->get("art")) {
            $articleId = $request->query->get("art");
            $article = $articleRepository->findArticleById($articleId);
            $date = $article -> getDate();
        }


        else

        {
            $article = new Article();
            $date = new DateTime;

        }

        $article -> setDate("");
        $article -> setUpdateDate("");
        $article -> setAuthorImage("");
        $article -> setArticleImage("");


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleData = $form->getData();

//            $category = $categoryRepository -> find($articleData->getCategories()[0]);


            $article -> setDate($date);
            $article -> setUpdateDate($date);
            $article -> setValid(0);

            $entityManager = $this->getDoctrine()->getManager();

//            $existingCat = $article -> getCategories();

//            foreach($existingCat->toArray() as $exCat) {
//                $article -> removeCategory($exCat);
//                $exCat -> removeArticle($article);
//                $entityManager->persist($exCat);
//                $entityManager->persist($article);
//
//            }

            if ($articleData -> getAuthorImage()) {

                // Renommage de l'image téléchargée et renvoi vers le dossier de stockage

                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $image = $articleData->getAuthorImage();
                $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();

                // moves the file to the directory where brochures are stored
                $image->move(
                    $this->getParameter('persons_img_directory'),
                    $imageName
                );

                $article->setAuthorImage($imageName);

            }


            if ($articleData -> getArticleImage()) {

                // Renommage de l'image téléchargée et renvoi vers le dossier de stockage

                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $image = $articleData->getArticleImage();
                $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();

                // moves the file to the directory where brochures are stored
                $image->move(
                    $this->getParameter('persons_img_directory'),
                    $imageName
                );

                $article->setArticleImage($imageName);

            }

            $categories = $articleData -> getCategories();

            foreach($categories as $cat) {
                $article -> addCategory($cat);
//                $cat -> getArticles() -> add($article);
                $entityManager->persist($cat);
                $entityManager->persist($article);
            }

//            $article->getCategories()->add($category);

//            $entityManager->persist($category);
//            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("adminArticle");
//            return $this->render("essai.html.twig", array(
//                'data' => array($categories[0])));
        }


        return $this->render("formArticle.html.twig", array(
            'form' => $form->createView()
        ));



    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Suppression de l'image dans l'organisme public ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


//    public function deleteAuthorImage(Request $request, OrganismPublicRepository $organismPublicRepository)
//    {
//
//        if ($request->isXMLHttpRequest()) // pour vérifier la présence d'une requete Ajax
//        {
//
//            // Récupération du nom de l'image à supprimer et de l'ID de l'organisme auquel elle est rattachée,
//            // envoyés par JS
//
//            $imageName = $request -> request -> get("imageName");
//            $orgPubId = $request -> request -> get("orgPubId");
//
//            // Création de l'accès aux dossiers contenant les fichiers
//
//            $fileSystem = new Filesystem();
//
//            // Récupération de la route du fichier, envoyée par JS, complétée du nom de l'image
//
//            $imagePath = $request -> request -> get("imagePath").$imageName;
//
//            // Suppression de l'image si elle est présente dans le dossier
//
//            if($fileSystem->exists($imagePath) == true){
//                $fileSystem->remove($imagePath);
//            }
//
//            // Récupération de l'entité de données publiques de l'organisme concerné
//
//            $organismPublic = $organismPublicRepository -> findOneById($orgPubId);
//
//            // Suppression du nom de l'image dans l'entité et enregistrement en BDD
//
//            $organismPublic -> setImage(null);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($organismPublic);
//            $em->flush();
//
//
//        }
//
//        return new JsonResponse("Delete image ok");
//
//
//    }



}
