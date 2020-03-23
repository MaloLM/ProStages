<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        
    }

   /**
     * @Route("inscription", name="app_signin")
     */
    public function inscription(Request $requetteHttp, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        // creation d'un unitlisateur initialement vierge
        $utilisateur = new User();

        // creation d'un objet formulaire pour saisir un utilisateur
        $formulaireUtilisateur = $this -> createForm(UserType::class, $utilisateur );

        // analyse de la dernière requette http  + récupération des attributs de l'object concerné 

        $formulaireUtilisateur -> handleRequest($requetteHttp);

        //traiter les données du formulaire s'il a été soumi
        if ( $formulaireUtilisateur -> isSubmitted() && $formulaireUtilisateur -> isValid() )
        {
            // attribuer un role a l'utilisateur
            $utilisateur->setRoles(['ROLE_USER']);

            // encoder le mdp de l'utilisateur
            $motDePasseEncode = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($motDePasseEncode);


            // enregistrer l'utilisateur en BD
            $manager -> persist($utilisateur);
            $manager->flush();

            //redirection de l'utilisateur vers la page affichant la list des entreprises
            return $this->redirectToRoute('app_login'); 
        }
        // générer la vue représentant le formulaire
        $vueFormulaireUtilisateur =  $formulaireUtilisateur -> createView();
                    
        // afficher la page d'ajout d'une ressource 
        return $this->render('security/inscription.html.twig',
        ['vueFormulaireUtilisateur' => $vueFormulaireUtilisateur]);
        
    }


    
}
