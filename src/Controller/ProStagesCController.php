<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProStagesCController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('pro_stages_c/index.html.twig',[
            'controller_name'=>'ProStagesCController',]);
    }
    
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises()
    {
       return $this->render('pro_stages_c/entreprises.html.twig',[
           'controller_name'=>'ProStageCController',]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations()
    {
        return $this->render('pro_stages_c/formations.html.twig',[
            'controller_name'=>'ProStageCController',]);
    }

      /**
     * @Route("/ressources/{idRessource}", name="ProStage_Ressources")
     */
    public function afficher_ressources($idRessource)
    {
        return $this->render('pro_stages_c/affichageRessources.html.twig',[
            'idRessource'=>$idRessource]);
    }

    /**
     * @Route("/afficher/stage", name="afficher_stage")
     */
    public function afficher_stage()
    {
        return $this->render('pro_stages_c/afficherStage.html.twig',[
            'controller_name'=>'ProStageCController',]);
    }
}
