<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 28/04/2018
 * Time: 14:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use App\Entity\User;
use App\Repository\OrganismRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ResetPasswordType;
use App\Form\RegistrationType;
use App\Form\UserType;

use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;




class SecurityController extends Controller
{



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


     public function __construct(AuthorizationCheckerInterface $authorizationChecker) {
          $this->authorizationChecker = $authorizationChecker;
     }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Connexion ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function loginAction(Request $request)

    {

        // Si le visiteur est déjà identifié, on le redirige vers l'accueil

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {


                return $this->redirectToRoute('index');

        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)

        $authenticationUtils = $this->get('security.authentication_utils');

        // Sinon, on affiche le formulaire de connexion
        //
        return $this->render('security/login.html.twig', array(

            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),

        ));
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Vérification qu'un utilisateur est connecté ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function loginCheckAction(AuthorizationCheckerInterface $authChecker)
    {

        // Si l'organisme ou l'administrateur n'est pas connecté, affichage de la page de connexion requise

        if (!$authChecker->isGranted('ROLE_ADMIN')) {

            return $this->render('security/requiredLog.html.twig');
        }

        // Sinon, renvoi vers la page d'administration de l'organisme

        return $this->redirectToRoute('index');
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~ Redirection vers la page demandant la déconnexion de l'utilisateur ~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function requiredLogout()
    {

        return $this->render('security/requiredLogout.html.twig');
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Affichage et validation du formulaire user de l'organisme ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function registrationUser(Request $request, Session $session, UserPasswordEncoderInterface
                                            $passwordEncoder, TokenGeneratorInterface $tokenGenerator, \Swift_Mailer $mailer)
    {

        // Création du formulaire d'ajout d'un organisme à partir d'une nouvelle entité

        $userForm = new User();

        $form = $this->createForm(UserType::class, $userForm);

        $form->handleRequest($request);

        // Si le formulaire est validé, stockage des données dans la session

        if ($form->isSubmitted() && $form->isValid()) {

            $user = new User();

            $password = $passwordEncoder->encodePassword($user, $userForm->getPlainPassword());
            $user->setPassword($password);
            $user->setUsername($userForm->getUsername());
            $mail = $userForm->getEmail();
            $user->setEMail($mail);

            $user->setIsActive(0);

            $user->setRoles(['ROLE_ADMIN']);

            // Création du token
            $token = $tokenGenerator->generateToken();
            $user->setToken($token);

            // Enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new \Datetime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Finalisation de votre inscription'))
                ->setFrom('sylvie@helvie.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(

                        'mailActiveUser.html.twig',

                        array(
                            'key' => $token
                        )

                    ),
                    'text/html'
                );

            $mailer->send($message);

            $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez 
            renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");

            return $this->render("security/userCreateMessage.html.twig");


        }

        // Affichage du formulaire user de l'organisme

        return $this->render('formUser.html.twig', [
            'form' => $form->createView()
        ]);
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~ Affichage du formulaire d'envoi d'adresse mail pour demander réinitialisation du mot de passe~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



    public function requestResetPassword(Request $request, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        // création d'un formulaire "à la volée", afin que l'internaute puisse renseigner son mail
        $form = $this->createFormBuilder()

            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email(),
                    new NotBlank()
                ]
            ])


            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // Récupération de l'user
            $user = $em->getRepository(User::class)->loadUserByUsername($form->getData()['email']);

            // aucun email associé à ce compte
            if (!$user) {
                $request->getSession()->getFlashBag()->add('warning', "Cet email n'existe pas.");
                return $this->redirectToRoute("resetPassword");
            }

            // Création du token
            $token = $tokenGenerator->generateToken();
            $user->setToken($token);

            // Enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new \Datetime());
            $em->flush();

            // Envoi du mail de réinitialisation

            $message = (new \Swift_Message('Changement de votre mot de passe'))
                ->setFrom('sylvie@helvie.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(

                        'mails/passChangeMail.html.twig',

                        array(
                            'user' => $user
                        )

                    ),
                    'text/html'
                )

            ;

            $mailer->send($message);

            $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez 
            renouveler votre mot de passe. Le lien est valable 1 heure");

            return $this->redirectToRoute("login");
        }

        return $this->render('security/passwordRequest.html.twig', [
            'form' => $form->createView()
        ]);
    }





//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Vérification de la validité de la date du token~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    // si supérieur à 24h, retourne false
    // sinon retourne true

    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;
        }

        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 2400;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Affichage du formulaire de nouveau mot de passe et enregistrement~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function newPassword(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 24h
        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {
            throw new AccessDeniedHttpException();
        }

        // Création d'un formulaire avec l'entité user récupérée via id url

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // Encodage et injection du mot de passe

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // réinitialisation du token à null pour qu'il ne soit plus réutilisable

            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été renouvelé.");

            return $this->redirectToRoute('login');

        }

        return $this->render('security/passwordReset.html.twig', [
            'form' => $form->createView()
        ]);
    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Création et envoi d'un nouveau mail d'activation de user ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function newMailActiveUser(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                                     TokenGeneratorInterface $tokenGenerator, \Swift_Mailer $mailer)
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){

            $user = $this->getUser();

            // Création du token

            $token = $tokenGenerator->generateToken();
            $user->setToken($token);

            // Enregistrement de la date de création du token

            $user->setPasswordRequestedAt(new \Datetime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Envoi du mail de d'activation

            $message = (new \Swift_Message('Finalisation de votre inscription'))

                ->setFrom('sylvie@helvie.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(

                        'mails/activeUserMail.html.twig',

                        array(
                            'key' => $token
                        )

                    ),
                    'text/html'
                );

            $mailer->send($message);

            $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez 
            renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");

            // Renvoi vers la page d'information de mail envoyé

            return $this->render('security/userCreateMessage.html.twig');


        }

    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~ Affichage de la page contenant un bouton pour nouvelle demande de mail d'activation ~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function repeatActiveUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        return $this->render('security/repeatActiveUser.html.twig');

    }




//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Activation de l'user ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function activeUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {


        // Création d'un formulaire "à la volée", afin que l'internaute puisse renseigner son mail

        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email(),
                    new NotBlank()
                ]
            ])
            ->getForm();
            $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $token = $request -> query -> get("key");

            $em = $this->getDoctrine()->getManager();

            // Récupération de l'User

            $user = $em->getRepository(User::class)->loadUserByUsername($form->getData()['email']);

            // interdit l'accès à la page si:
            // le token associé au membre est null
            // le token enregistré en base et le token présent dans l'url ne sont pas égaux
            // le token date de plus de 24h

            if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
            {
                throw new AccessDeniedHttpException();
            }


            // Réinitialisation du token à null pour qu'il ne soit plus réutilisable

            $user->setToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setIsActive(1);

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre compte a été activé.");

            return $this->redirectToRoute('login');

        }

        return $this->render('security/activeUser.html.twig', [
            'form' => $form->createView()
        ]);

    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



}


