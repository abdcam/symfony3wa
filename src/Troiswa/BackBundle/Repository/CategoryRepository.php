<?php

namespace Troiswa\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    // Afficher le nombre de catégorie
    public function findNombreCategory()
    {
        $query=$this->getEntityManager()->createQuery("
                       Select count(cat)
                       from TroiswaBackBundle:Category cat
                        ");
        //dump($query);
        //die;
//getSingleScalarResult() renvoi le nombre sans aucun commentaire
        return $query->getSingleScalarResult();
    }

    // Afficher les catégories dont la position est supérieur à 2
    public function findPositionCategory()
    {
        $query=$this->getEntityManager()->createQuery("
                       Select cat
                       from TroiswaBackBundle:Category cat
                       WHERE cat.position > 2
                        ");
        //dump($query);
        //die;
//getSingleScalarResult() renvoi le nombre sans aucun commentaire
        return $query->getResult();
    }
// Afficher les catégories dont le titre commence par "le"
    public function findCategoryDebutTitre($val_text)
    {
        $query=$this->getEntityManager()->createQuery("
                       Select cat.title
                       from TroiswaBackBundle:Category cat
                       WHERE cat.title LIKE :text")
                    ->setParameter("text", '%'.$val_text.'%');
        //dump($query);
        //die;
//getSingleScalarResult() renvoi le nombre sans aucun commentaire
        return $query->getResult();
    }

    public function findPositionCategoryForFormType()
    {
        $query=$this->createQueryBuilder('cat')
                    ->orderBy('cat.position', 'ASC');

        return $query;
    }
}
