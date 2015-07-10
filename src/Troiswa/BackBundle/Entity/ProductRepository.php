<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function findAllMaison()
    {
        $query=$this->getEntityManager()
                    ->createQuery(
                        "select prod
                        from TroiswaBackBundle:Product prod"
                                );
        return $query->getResult();
    }

    public function findProductByQuantity($qty=null)
        //createQueryBuilder fait le select et le from donc pas besoin de les faire et comme ca on peut mette where dans if mais createQuery ne le fait pas
    {
        $query=$this->createQueryBuilder("prod");
        if ($qty!=null)
            $query->where("prod.quantity>=:qtyval")
                 ->setParameter("qtyval",$qty);
        //dump($qty);
        //die;
        return $query->getQuery()->getResult();
    }

    // Afficher le nombre de produit dont la quantité est à 0
    public function findProductByNameZeroQty()
        //createQueryBuilder fait le select et le from donc pas besoin de les faire et comme ca on peut mette where dans if mais createQuery ne le fait pas
    {
        $query=$this->getEntityManager()->createQueryBuilder()
            ->select('prod.title')
            ->from('TroiswaBackBundle:Product', 'prod')
            ->where("prod.quantite <= 0");
        //dump($query->getQuery()->getResult());
        //die;
        return $query->getQuery()->getResult();
    }

    public function findProductActiv($qty=null)
    {
        $query=$this->getEntityManager()->createQuery("
                       Select count(prod)
                       from TroiswaBackBundle:Product prod
                       WHERE prod.active=1
                        ");

        //dump($query->getQuery()->getResult());
        //die;

        return $query->getResult();
    }

    // Afficher le nombre de produit actif
    public function findProductActivInactv()
    {
        $query=$this->getEntityManager()->createQuery("
                       Select count(prod.active) as Nbre, prod.active
                       from TroiswaBackBundle:Product prod
                       GROUP by prod.active
                        ");

        return $query->getResult();
    }

// Afficher les produits dont le prix est compris entre 2 variables: ex: 10 et 20
    public function findProductBetweenPrice($min,$max)
    {
        $query=$this->getEntityManager()->createQuery("
                       Select prod.prix
                       from TroiswaBackBundle:Product prod
                       where prod.prix between :minprice and :maxprice
                        ")
                ->setParameter("minprice",$min)
                ->setParameter("maxprice",$max);

        return $query->getResult();
    }

}

