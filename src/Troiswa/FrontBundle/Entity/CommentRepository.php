<?php

namespace Troiswa\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    //ici on pouvait créer notre requette pôur recuperer le commentaire dans la basev de donnée
    //mais celle-ci a été créée dans le controlleur ProductFrontController donc on ne fait rien ici


    public function findAllCommentOfOneProduct($id)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('com')
            ->from('TroiswaFrontBundle:Comment', 'com')
            ->where('com.produit = :value')
            ->setParameter('value', $id);


    }



}
