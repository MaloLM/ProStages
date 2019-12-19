<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
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
}
