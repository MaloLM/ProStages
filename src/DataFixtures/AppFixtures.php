<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Creation d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        //Definition des Formations
        $dutInfo = new Formation();
        $dutInfo->setNomCourt("DUT Info");
        $dutInfo->setNomLong("DUT Informatique");

        $lpProg = new Formation();
        $lpProg->setNomCourt("Lp Prog");
        $lpProg->setNomLong("License professionnel Programmation avancée");

        $lpNum = new Formation();
        $lpNum->setNomCourt("Lp Num");
        $lpNum->setNomLong("License professionnel Métiers du Numérique");

        $tabTypeFormation = array($dutInfo, $lpNum, $lpProg); //Tableau des formations

        foreach ($tabTypeFormation as $typeModule) {
            $manager->persist($typeModule);
        }

//Definition des Entreprises
        $nbEntreprises = $faker->numberBetween($min = 10, $max = 20);
        $tabEntreprise = array();

        for ($i = 0; $i < $nbEntreprises ; $i++) { 
            
            //Création d'une entreprise
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivite($faker->sentence($nbWords =80, $variableNbWords = true));
            $nomEntreprise = $entreprise->getNom();
            
            //Préparation du nom de l'entreprise
            $nomEntreprise = str_replace(' ','_',$entreprise->getNom()); //Enlève les espace au nom d'entreprise
            $nomEntreprise = str_replace('.','',$nomEntreprise); //Enlève les points       
            $entreprise->setSiteWeb($faker->regexify('http\:\/\/'.$nomEntreprise.'\.'.$faker->tld));

            //mettre dans tableau initialisé
            array_push($tabEntreprise, $entreprise);

            $manager->persist($entreprise);
        }
        


//Definition des stages
$nbStages = $faker->numberBetween($min = 1, $max = 3);
foreach ($tabEntreprise as $entreprise){
    for ($i = 0 ; $i < $nbStages; $i++)
    {
        // ajouter a un stage a l'entreprise courante
            //Création d'un stage
            $stage = new Stage();
            $stage->setTitre($faker->sentence($nbWords =15, $variableNbWords = true));

            $nbDomaines = $faker->numberBetween($min = 1, $max = 5);
            $domaines = "";
            for($d = 0 ; $d < $nbDomaines ; $d++)
            {
                $domaines . "coucou";
                $domaines . ", ";
            }

            $stage->setDomaine($domaines);
            $stage->setDescription($domaines);
            $stage->setEmail($faker->companyEmail);
            $stage->setEntreprise($entreprise);

        //Ajout d'une formation au stage
            $numTypeFormation = $faker->numberBetween($min=0, $max=2);
            $stage->addFormation($tabTypeFormation[$numTypeFormation]);

         //Ajout du stage à la formation
            $tabTypeFormation[$numTypeFormation]->addStage($stage);
            $manager->persist($tabTypeFormation[$numTypeFormation]);

         //Ajout du stage à l'entreprise
            $entreprise->addStage($stage);
            $manager->persist($entreprise);

        $manager->persist($stage);
    }
}      
$manager->flush(); 
            
    }

        
}
