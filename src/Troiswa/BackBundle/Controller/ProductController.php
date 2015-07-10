<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Form\ProductType;

class ProductController extends Controller
{
    public function ProductAction()
    {
        $em=$this->getDoctrine()->getManager();
        $products=$em->getRepository("TroiswaBackBundle:Product")
            ->findAll();
        //dump($products);
        //die();
        return $this->render("TroiswaBackBundle:Product:Product.html.twig", ['tableauProducts' => $products]);
    }

    public function Product_infoAction($idprod)
    {
        /* $products = [
            1 => [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            2 => [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            3 => [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            4 => [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ]; */

        //find appliqué que sur les id.
        $em=$this->getDoctrine()->getManager();
        $oneProduct=$em->getRepository("TroiswaBackBundle:Product")
                        ->find($idprod);
        //dump($oneProduct);
        //die();

        if($oneProduct == false)
        {
            throw $this->createNotFoundException("cet produit n'existe pas");
        }

        //$product=$products[$idprod];

        /*
        - Afficher le titre et la description de tous les article
    - Afficher uniquement pour le premier article : Ceci est le premier article (pas sur id)
    - Afficher le nombre d article
    - Afficher pour l article ayant l id 4 un titre par défaut
    - Parcourez de nouveau les articles mais dans l ordre inverse
    - Parcourez de nouveau les articles mais affichez uniquement l article 2 et 3  */

        return $this->render("TroiswaBackBundle:Product:Product_info.html.twig", ['tableauProducts' => $oneProduct]);
    }

    public function addproductAction(Request $request)
    {
        //cette methode creer et fait appelle à productType.php comme include et equivalent à ce qui est en commentaire ce ProductType a été crée au console ajouter les tables sans getForm() qui fait meme que creatForm()
        $product=new Product();

        //$product->setTitle("toto");
        /*
        $formproduct=$this->createFormBuilder($product)
                        ->add("title","text")

                        ->add("description","textarea")
                        ->add("prix")

                        ->add("quantite","integer")
                        ->add("active")
                        ->add("send","submit")

                        ->getForm();
        */
        //dump($product);
        $formproduct=$this->createForm(new ProductType(), $product)
            ->add("send","submit");


        $formproduct->handleRequest($request);

        if($formproduct->isValid())
        {
            //dump($product);
            //die('error');

            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            //$product->setTitle("Modification après persist");
            $em->flush();

            $this->get("session")->getFlashBag()->add("success","votre produit été bien créé");

            return $this->redirectToRoute("trois_back_product");
        }

        return $this->render("TroiswaBackBundle:Product:create-product.html.twig",
            [
                "formproduct"=> $formproduct->createView()
            ]
        );
    }
    public function editeAction($idprod,Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $product = $em-> getRepository("TroiswaBackBundle:Product")
                    ->find($idprod);
        if(empty($product))
        {
            throw $this->createNotFoundException("Attention");
        }

        $formUdaptProduct=$this->createForm(new ProductType(), $product)
                            ->add('update', 'submit');

        $formUdaptProduct->handleRequest($request);

        if($formUdaptProduct->isValid())
        {
            $em->flush();

            $this->get("session")->getFlashBag()->add("success","votre produit été bien mis à jour");

            return $this->redirectToRoute("trois_back_Product");
        }

        return $this->render("TroiswaBackBundle:Product:edite_product.html.twig",
            [
                "formUdaptProduct"=> $formUdaptProduct->createView()
            ]);
    }

    public function suppAction($idprod,Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $product = $em-> getRepository("TroiswaBackBundle:Product")
            ->find($idprod);
        if(empty($product))
        {
            throw $this->createNotFoundException("Attention");
        }

        $em->remove($product);
        $em->flush();

        return $this->render("TroiswaBackBundle:Product:supp_product.html.twig");
    }

    public function  productActiveAction(Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $products = $em-> getRepository("TroiswaBackBundle:Product")
            //findBy est une rquette en doctrine
                        ->findBy(["active"=>true], ["prix"=>"Asc"]);
        return $this->render("TroiswaBackBundle:Product:Product.html.twig", ['tableauProducts' => $products]);
    }

    public function  productLimitAction(Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $limit = $request->query->get('nb');
        $products = $em-> getRepository("TroiswaBackBundle:Product")
            //findBy est une rquette en doctrine
            ->findBy(["active"=>true], ["prix"=>"Asc"], $limit);
        return $this->render("TroiswaBackBundle:Product:Product.html.twig", ['tableauProducts' => $products]);
    }

    public function productChangeVisibAction($idprod, $active,Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $product = $em-> getRepository("TroiswaBackBundle:Product")
            ->find($idprod);
        if(empty($product))
        {
            throw $this->createNotFoundException("Attention");
        }
        $product->setActive($active);
        $em->flush();
        return $this->redirectToRoute('trois_back_Product');
    }
}