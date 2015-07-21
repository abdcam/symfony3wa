<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\User;

class MainController extends Controller
{
    public function indexsave_Action(Request $request)
    {
        //dump($request->query->get("page","default")); // equival à $_GET["page"]
        //die();
        //return new Response("hello");
        //TroiswaBackBundle:Product=facon d'ecrire la table et prod est son alliace
        //select prod=select * à l'ancienne et affiche tous les produits = findAll de doctrine
        $em=$this->getDoctrine()->getManager();
        $idprod=5;
        $query=$em->createQuery("select prod
        from TroiswaBackBundle:Product prod
        where prod.id=:idproduct")
            ->setParameter("idproduct",$idprod);
        $products=$query->getResult();
        dump($products);
        die();

        return $this->render("TroiswaBackBundle:Main:index.html.twig");
    }

    public function indexSave2_Action(Request $request)
    {
        //dump($request->query->get("page","default")); // equival à $_GET["page"]
        //die();
        //return new Response("hello");
        //TroiswaBackBundle:Product=facon d'ecrire la table et prod est son alliace
        //select prod=select * à l'ancienne et affiche tous les produits = findAll de doctrine

        $em=$this->getDoctrine()->getManager();
        $idprod=15;
        $query=$em->createQuery("select prod
        from TroiswaBackBundle:Product prod
        where prod.quantite < :idproduct")
            ->setParameter("idproduct",$idprod);
        $products=$query->getResult();
        //dump($products);
        //die();

        return $this->render("TroiswaBackBundle:Main:index.html.twig");
    }


    public function indexAction(Request $request)
    {
        /* code de securité
         * $user = new User();
        $factory = $this->get('security.encoder_factory');

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('admin', null);
        echo $password;
        die;*/
        $em=$this->getDoctrine()->getManager();
        $idprod=15;
        $query=$em->createQueryBuilder()
                    ->select ("prod")
                    ->from ("TroiswaBackBundle:Product", "prod")
                    ->getQuery();
        $products=$query->getResult();
        //dump($products);
        //die();

//appel à la methode findAllMaison de PoductRepository.php de Entity
        $em=$this->getDoctrine()->getManager();
        $products=$em->getRepository("TroiswaBackBundle:Product")->findAllMaison();

        $em=$this->getDoctrine()->getManager();
        $productQty=$em->getRepository("TroiswaBackBundle:Product")->findProductByQuantity();

        $em=$this->getDoctrine()->getManager();
        $productZeroQty=$em->getRepository("TroiswaBackBundle:Product")
                            ->findProductByNameZeroQty();

        $em=$this->getDoctrine()->getManager();
        $productActif=$em->getRepository("TroiswaBackBundle:Product")
                        ->findProductActiv();

        $em=$this->getDoctrine()->getManager();
        $nbCat=$em->getRepository("TroiswaBackBundle:Category")
                ->findNombreCategory();
        //dump($nbCat);die;

        $em=$this->getDoctrine()->getManager();
        $prodActivInanact=$em->getRepository("TroiswaBackBundle:Product")
                            ->findProductActivInactv();
        //dump($prodActivInanact);
       // die;

        $em=$this->getDoctrine()->getManager();
        $positionCategory=$em->getRepository("TroiswaBackBundle:Category")
                            ->findPositionCategory();
        //dump($positionCategory);
        //die;

        $em=$this->getDoctrine()->getManager();
        $productBetween=$em->getRepository("TroiswaBackBundle:Product")
                            ->findProductBetweenPrice(10,20);
        //dump($productBetween);
        //die;

        $em=$this->getDoctrine()->getManager();
        $categoryDebutTitr=$em->getRepository("TroiswaBackBundle:Category")
            ->findCategoryDebutTitre("text");
        //dump($categoryDebutTitr);
       // die;
        return $this->render("TroiswaBackBundle:Main:index.html.twig");
    }

    public function errorProductAction()
    {
        $em=$this->getDoctrine()->getManager();
        $productBetween=$em->getRepository("TroiswaBackBundle:Product")
            ->findErrorProductBetweenPrice(5,20);

        return $this->render("TroiswaBackBundle:Main:errorProduct.html.twig", ["productBetween" => $productBetween]);
    }
}
