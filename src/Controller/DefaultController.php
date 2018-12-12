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
use App\Entity\CommentResponse;
use App\Repository\CommentRepository;
use App\Repository\CommentResponseRepository;
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


class DefaultController extends Controller
{


//    public function owlHomeDisplay(Request $request, ArticleRepository $articleRepository)
//    {
//
//        return $this-> render("owlHome.html.twig");
//
//    }

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


    public function owlServicesDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlServices.html.twig");

    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function owlBlogDisplay(Request $request, ArticleRepository $articleRepository)
    {

        return $this-> render("owlBlog.html.twig");

    }

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

        // Création du formulaire avec une nouvelle entité

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
            $thisProspect -> setInformation($information."<p><b>Inscription à la newsletter - ".$today2."</b></p>");

            $em = $this->getDoctrine()->getManager();
            $em->persist($thisProspect);
            $em->flush();

            // Redirection vers le formulaire d'activité

            return $this->redirectToRoute('index');

        }

        // Affichage du formulaire d'activité

        return $this->render('owlHome.html.twig', [
            'formNL' => $formNL->createView(),
        ]);

    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~





    public function formContactDisplay(Request $request, ProspectRepository $prospectRepository)
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





}
