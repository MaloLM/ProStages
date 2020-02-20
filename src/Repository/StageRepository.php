<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

      /**
      * @return Stage[] Returns an array of Stage objects
      */
    
    public function findStageByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s') // s pour stage
            ->join('s.entreprise','e')
            ->where('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->getQuery()
            ->getResult()
        ;
    }


     /**
      * @return Stage[] Returns an array of Stage objects
      */

    public function findStageByFormation($nomFormation)
    {
        return $this->createQueryBuilder('s') // s pour stage
            ->join('s.formations','f')
            ->where('f.nomCourt = :nomFormation')
            ->setParameter('nomFormation', $nomFormation)
            ->getQuery()
            ->getResult()
        ;
    }


        /**
      * @return Stage[] Returns an array of Stage objects
      */

      public function findStagesEntreprise()
      {
        $gestionnaireEntite = $this->getEntityManager();
        
        $requete = $gestionnaireEntite->createQuery(
        'SELECT s,e
        FROM App\Entity\Stage s
        JOIN s.entreprise e'

        );
        return $requete->execute();
      }
     
   
    /**
     * @return Stage[] Returns an array of Stage objects
     */
    public function findStageByFormationDQL($nomFormation)
    {
        // Recuperation du gestionnaire d'entité

        $gestionnaireEntite = $this->getEntityManager();

        // Construction de la requete sur mesure

        $requete = $gestionnaireEntite ->createQuery('
        SELECT s
        FROM App\Entity\Stage s
        JOIN s.formations f
        WHERE f.nomCourt = :nomFormation
        ');

    // definition de la valeur du paramètre
    $requete ->setParameter('nomFormation',$nomFormation);


        // Execution de la requete et envoie des résultats
        return $requete->execute();
    }
    /**
      * @return Stage[] Returns an array of Stage objects
      */
    
      public function findAll()
      {
        //Récupération du gestionnaire d'entité
        $entityManager = $this->getEntityManager();

        //Construction de la requête
        $requete = $entityManager->createQuery(
            'SELECT s, e
             FROM App\Entity\Stage s
             JOIN s.entreprise e'
        );

        //Execution de la requête
        return $requete->execute();
      }
    
}
