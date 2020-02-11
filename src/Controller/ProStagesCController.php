<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;


class ProStagesCController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        // récupérer le répository de l'entité StageFormation
        $repositoryAcceuil = $this->getDoctrine()->getRepository(Stage::class);

        // récuperer les ressources enregistrées en BD 
        $stages = $repositoryAcceuil->findAll();

        // envoyer les ressources récupérées a la vue chargée de les afficher
        return $this->render('pro_stages_c/index.html.twig',['stages' => $stages]);
    }
    
    /**
     * @Route("/entreprises", name="entreprises")
     */
        public function entreprises()
    {
           // récupérer le répository de l'entité Entreprise
           $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        
           // récuperer les ressources enregistrées en BD
           $entreprises = $repositoryEntreprise->findAll();
   
           // envoyer les ressources récupérées a la vue chargée de les afficher
           return $this->render('pro_stages_c/entreprises.html.twig',['entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations()
    {
        // récupérer le répository de l'entité Formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        
        // récuperer les ressources enregistrées en BD
        $formations = $repositoryFormation->findAll();

        // envoyer les ressources récupérées a la vue chargée de les afficher
        return $this->render('pro_stages_c/formations.html.twig',['formations' => $formations]);
    }


    /**
     * @Route("/afficher/stage/{id}", name="afficher_stage")
     */
    public function afficher_stage($id)
    {
    
        // récupérer le répository de l'entité Stage
        $repositoryAffStage = $this->getDoctrine()->getRepository(Stage::class);
        
        // récuperer les ressources enregistrées en BD
        $ressourcesStages = $repositoryAffStage->findAll();

        // envoyer les ressources récupérées a la vue chargée de les afficher
        return $this->render('pro_stages_c/affichageRessources.html.twig',[
            'id' => $id, 
            'ressource' => $ressourcesStages ]);

    }


    /**
     * @Route("/tri/{type}/{nom}", name="tri_stage")
     */
    public function stages_tries($type,$nom)
    {
        // récuperer les ressources enregistrées en BD  // récupérer le répository de l'entité Stage

        if($type=="entreprises")
        {
            $repoStages = $this->getDoctrine()->getRepository(Stage::class);
            //$stages = $repoStages->findByEntreprise($id);
            $stages = $repoStages->findStageByEntreprise($nom);
            
        }
        elseif($type=="formations")
        {
            //$repoFormation = $this->getDoctrine()->getRepository(Formation::class);
            //$stages = $repoFormation->find($id)->getStages();
            $repoStages = $this->getDoctrine()->getRepository(Stage::class);
            $stages = $repoStages->findStageByFormation($nom);
        }

        // envoyer les ressources récupérées a la vue chargée de les afficher
        return $this->render('pro_stages_c/index.html.twig',[
            'stages' => $stages]);
    }


      /**
     * @Route("/ajouter/entreprise", name="ajouterUneEntreprise")
     */
    public function ajouterUneEntreprise(Request $requetteHttp, ObjectManager $manager)
    {
        // creation d'un stage initialement vierge
        $entreprise = new Entreprise();

        // creation d'un objet formulaire pour saisir un stage
        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                 -> add ('nom',TextType::class)
                                 -> add ('activite',TextType::class)
                                 -> add ('adresse',TextareaType::class)
                                 -> add ('siteWeb',UrlType::class)
                                 -> getForm();

        // générer la vue représentant le formulaire
        $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

        // analyse de la dernière requette http  + récupération des attributs de l'object concerné 

        $formulaireEntreprise -> handleRequest($requetteHttp);

        //traiter les données du formulaire s'il a été soumi
        if ($formulaireEntreprise -> isSubmitted() )
        {
            // enregistrer l'entreprise en BD
            $manager -> persist($entreprise);
            $manager->flush();

            //redirection de l'utilisateur vers la page affichant la list des entreprises
            return $this->redirectToRoute('entreprises'); 
        }
                    
        // afficher la page d'ajout d'une ressource 
        return $this->render('pro_stages_c/ajoutEntreprise.html.twig',
        ['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
        
    }
}
