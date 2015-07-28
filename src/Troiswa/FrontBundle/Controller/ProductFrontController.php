<?php

namespace Troiswa\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Troiswa\BackBundle\Entity\Product;
use Troiswa\BackBundle\Util\Utility;

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
    //On a mis tout en commentaire parce qu'on a crée un service qui remplace tout ce code Aller voir BackBundle/Util/Cart.php et config/services.yml avantage notre controller est alléger
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

    /*
            // Récupération des informations du formulaire d'ajout au panier
            $qty = $request->request->getInt('qty');

            if ($qty > 0) {
                $session = $request->getSession();
                //$session->remove('cart');

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

    */

        $qty = $request->request->getInt('qty');

        $cartService = $this->get('troiswa_front.cart');

        $cartService->add($product, $qty);

        return $this->redirectToRoute('troiswa_front_cart');
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
 }  */  /* NB: cart=pannier */

    public function cartAction(Request $request)
    {
/*
 *
// Liste de tous les services
// php ap/console container:debug

        $util1 = new Utility();
        dump($util1);
        dump($util1->bonjour());

        $util = new Utility();

        dump($util->bonjour());
        die;
        */
        /*
        // MISE EN SERVICE
        $util2 = $this->get('troiswa_back.monsuperservice');
        dump($util2);
        dump($util2->bonjour());

        $util3 = $this->get('troiswa_back.monsuperservice');
        dump($util3);
        // FIN DE MISE EN SERVICE

        die; */


        $session = $request->getSession();
        $cart = json_decode($session->get('cart'), true);
        $products = [];

        if ($cart) {
            $em = $this->getDoctrine()->getManager();
            $idProducts = array_keys($cart);
            $products = $em->getRepository('TroiswaBackBundle:Product')
                            ->getProductInCart($idProducts);
        }

        //dump($cart);
        //die;
        return $this->render('TroiswaFrontBundle:ProductFront:cart.html.twig', ['products' => $products, 'panier' => $cart]);
    }
    /*
        {% for onproduct in products %}
        {{ panier[onproduct.id].quantity }}
        {% endfor %}
    */
 /*
<?php

    function getLittleDescription($texte, $nbchar = 50)
    {
        return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,strrpos(substr($texte,0,$nbchar)," "))."..." : $texte);
    }

*/
    public function suppAction(Product $product, Request $request)
    {
        // Code de la suppression du produit
        //si le pannier n'est pas vide
        $session = $request->getSession();
        $cart = json_decode($session->get('cart'), true);

        //dump($cart);
        //dump($product);
        //die;
        //si le produit existe dans le pannier
        if ($cart && array_key_exists($product->getId(), $cart))
           
        {
            //on supp avec unset pour supprimer le produit du tableau
            unset($cart[$product->getId()]);
            //ici on sauvegarde le nouveau tablo dans la session
            $session->set('cart', json_encode($cart));
        }

        // Si je suis en ajax
        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse("Votre produit a bien été supprimé");
        }

        return $this->redirectToRoute('troiswa_front_cart'); 
    }
    public function plusAction(Product $product, Request $request)
    {
        $session = $request->getSession();
        $cart = json_decode($session->get('cart'), true);

        //$em=$this->getDoctrine()->getManager();
        //$product=$em->getRepository('TroiswaBackBundle:Product');
        //dump($cart);
        //ici tablo des tablo grand tab c'est $cart ki contient:(71=>quantite=>1) dont idproduct=71 ki pointe sur quantite ki est egale à 1. On recupert tout ca en php par $cart[$product->getId()]["quantity] NB: get parce ke id est private.
        $qtyNewplus = $cart[$product->getId()]["quantity"] + 1;
        $cart[$product->getId()]["quantity"] = $qtyNewplus;

        //Puis on enregistre le pannier dans la session ou on enregistre la nouvelle session.
        $session->set('cart', json_encode($cart));
        //dump($cart);
        //dump($product);
        //die('je suis ici');
        return $this->redirectToRoute('troiswa_front_cart');
    }
    public function moinsAction(Product $product, Request $request)
    {
        $session = $request->getSession();
        $cart=json_decode($session->get('cart'),true);
        $Newqtymoins=$cart[$product->getId()]['quantity'] - 1;
        if ($Newqtymoins < 1)
        {
            unset($cart[$product->getId()]);
        }
        else
        {
            $cart[$product->getId()]['quantity']=$Newqtymoins;
        }
        //enregistrer le pannier
        $session->set('cart',json_encode($cart));
        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse("Votre produit a bien été supprimé");
        }

        return $this->redirectToRoute('troiswa_front_cart');
    }
}