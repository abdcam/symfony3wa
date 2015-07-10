<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Category;
use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Form\CategoryType;
use Troiswa\BackBundle\Form\ProductType;

class CategoryController extends Controller
{
    public function CategoryAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("TroiswaBackBundle:Category")
            ->findAll();
        //dump($categories);
        //die();

        return $this->render("TroiswaBackBundle:Category:Category.html.twig", ['tableauCategory' => $categories]);
    }

    public function Category_infoAction($idCat)
    {
        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];

        /* exo 030715
         * ATTENTION : LE TABLEAU A ETE MODIFIE
- Afficher uniquement les catégories dont la propriété active est à true
- Afficher le nombre de caractère à compter de la description
- Trouver un moyen que le navigateur interprète le strong contenu dans la description
  de la catégorie femme
- Conserver le saut de ligne pour la catégorie homme
         *
         */

       if(!isset($categories[$idCat]))
        {
            throw $this->createNotFoundException("cette categorie n'existe pas");
        }
        $cat=$categories[$idCat];

        return $this->render("TroiswaBackBundle:Category:Category_info.html.twig", ['tableauCategory' => $cat]);
    }

    public function addCategoryAction(Request $request)
    {
        $category = new Category();

        $formcategory=$this->createForm(new CategoryType(), $category)
            ->add("button","submit");


        $formcategory->handleRequest($request);

        if($formcategory->isValid())
        {
            //dump($category);
            //die('error');

            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            //$product->setTitle("Modification après persist");
            $em->flush();

            $this->get("session")->getFlashBag()->add("success","votre categorie été bien créée");

            return $this->redirectToRoute("trois_back_Category");
        }
        return $this->render("TroiswaBackBundle:Category:Category-add.html.twig",
            [
                "formcategory"=> $formcategory->createView()
            ]
        );
    }
    public function editeCategoryAction($idCat,Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $cat = $em-> getRepository("TroiswaBackBundle:Category")
            ->find($idCat);
        if(empty($cat))
        {
            throw $this->createNotFoundException("Attention");
        }

        $formUdaptCategory=$this->createForm(new CategoryType(), $cat)
            ->add('update', 'submit');

        $formUdaptCategory->handleRequest($request);

        if($formUdaptCategory->isValid())
        {
            $em->flush();

            $this->get("session")->getFlashBag()->add("success","votre catégorie a été bien mise à jour");

            return $this->redirectToRoute("trois_back_Category");
        }
        return $this->render("TroiswaBackBundle:Category:edite_category.html.twig",
            [
                "formUdaptProduct"=> $formUdaptCategory->createView()
            ]);
    }

    public function suppAction($idCat,Request $request)
    {
        $em=$this -> getDoctrine()-> getManager();
        $category = $em-> getRepository("TroiswaBackBundle:Category")
            ->find($idCat);
        if(empty($category))
        {
            throw $this->createNotFoundException("Attention");
        }
        $em->remove($category);
        $em->flush();

        return $this->render("TroiswaBackBundle:Category:supp_product.html.twig");
    }

    public function AllCategoriesAction()
    {
        $em=$this -> getDoctrine()-> getManager();
        $category = $em-> getRepository("TroiswaBackBundle:Category")
            ->findAll();

        return $this->render("TroiswaBackBundle:Category:renderCategorie.html.twig",["category"=>$category]);
    }

}


