<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Brand;
use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Form\BrandType;
use Troiswa\BackBundle\Form\CategoryType;
use Troiswa\BackBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BrandController extends Controller
{
    public function BrandAction()
    {
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository("TroiswaBackBundle:Brand")
            ->findAllMarque();
        //dump($categories);
        //die();

        return $this->render("TroiswaBackBundle:Product:VisuMarque.html.twig", ['tableauBrand' => $brand]);
    }

    public function Brand_AddAction(Request $request)
    {
        $Brand = new Brand();

        $formBrand = $this->createForm(new BrandType(), $Brand)
            ->add("button", "submit");

        $formBrand->handleRequest($request);

        if ($formBrand->isValid()) {
            //dump($category);
            //die('error');

            // upload
            $Logo = $Brand->getLogoimg();
            $Logo->upload();
            $Logo->setAlt($Brand->getTitle());

            $em = $this->getDoctrine()->getManager();

            // rajoute du persist de logo

            $em->persist($Logo);
            $em->persist($Brand);
            //$product->setTitle("Modification après persist");
            $em->flush();

            $this->get("session")->getFlashBag()->add("success", "votre Marque a été bien créée");

            return $this->redirectToRoute("trois_back_Category");
        }
        return $this->render("TroiswaBackBundle:Product:AjouterBrand.html.twig",
            [
                "formBrand" => $formBrand->createView()
            ]
        );
    }
}



