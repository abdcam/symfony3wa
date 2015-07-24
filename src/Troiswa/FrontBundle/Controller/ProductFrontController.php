<?php

namespace Troiswa\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Product;

class ProductFrontController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository("TroiswaBackBundle:Product")
            ->findAll();

        $dql = "SELECT produc FROM TroiswaBackBundle:Product produc WHERE produc.quantite > 0 AND produc.cover is not NULL ";

        $query = $em->createQuery($dql)->setMaxResults(3);

        $productSlider = $query->getResult();
        //dump($query->getResult());
        //die;

        return $this->render("TroiswaFrontBundle:ProductFront:ProductFront.html.twig", ["Product" => $product, "productSlider" => $productSlider]);
    }

    public function produitAction(Product $product)
    {

        return $this->render("TroiswaFrontBundle:ProductFront:show.html.twig", ["product" => $product]);
    }

    /*
        public function addCartAction(Product $product, Request $request)
        {
            // Récupération des informations du formulaire d'ajout au panier
            $qty = $request->request->getInt('qty');

            if ($qty > 0)
            {
                $session = $request->getSession();


                if ($session->get('cart'))
                {
                    $cart = (array)json_decode($session->get('cart'));
                }
                else
                {
                    $cart = [];
                }

                $contain = false;

                foreach($cart as $oneProduct)
                {
                    // Produit déjà dans le panier
                    if ($oneProduct->id_product == $product->getId())
                    {
                        // Ajout de la quantité à l'ancienne
                        $oneProduct->quantity = $oneProduct->quantity + $qty;
                        $contain = true;
                        break;
                    }
                }

                if ($contain == false)
                {
                    array_push($cart, ['id_product' => $product->getId(), 'quantity' => $qty]);
                }

                $session->set('cart', json_encode($cart));
            }

            return $this->redirectToRoute('troiswa_front_cart');
        }  meme chose ke svt */

    public function addCartAction(Product $product, Request $request)
    {
        // Récupération des informations du formulaire d'ajout au panier
        $qty = $request->request->getInt('qty');

        if ($qty > 0) {
            $session = $request->getSession();
            $session->remove('cart');

            if ($session->get('cart')) {
                $cart = json_decode($session->get('cart'), true);
            } else {
                $cart = [];
            }

            if (array_key_exists($product->getId(), $cart)) {
                $qty = $qty + $cart[$product->getId()]['quantity'];
            }

            $cart[$product->getId()] = ['quantity' => $qty];
            

        $session->set('cart', json_encode($cart));

    }

        return $this->redirectToRoute('troiswa_front_cart');

    }
}

   /*

    public function cartAction(Request $request)
    {
        $session = $request->getSession();
        $cart= json_decode($session->get('cart'));
        $idProduct = [];
        $products = [];

        foreach($cart as $tabproduct)
        {
            $idProduct[] = $tabproduct->id_product;
        }

        if ($idProduct)
        {
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository('TroiswaBackBundle:Product')->slmdkfsdmkfsdm($idProduct);
        }

        dump($products);
        die;
    }
}  */

public function cartAction(Request $request)
{
    $session = $request->getSession();
    $cart = json_decode($session->get('cart'), true);
    $products = [];

    if ($cart)
    {
        $em = $this->getDoctrine()->getManager();
        $idProducts = array_keys($cart);
        $products = $em->getRepository('')->fonction($idProducts);
    }

    return $this->render('', ['products' => $products, 'panier' => $cart])
  die;
}


    {% for onproduct in products %}
    {{ panier[onproduct.id].quantity }}
    {% endfor %}


