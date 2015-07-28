<?php

namespace Troiswa\BackBundle\Util;

use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    private $session;

    public function __construct(Session $serviceSession)
    {
        $this->session = $serviceSession;
    }

    public function add(Product $product, $qty = 1)
    {

        if ($qty > 0)
        {
            //$session = $request->getSession();

            if ($this->session->get('cart'))
            {
                $cart = json_decode($this->session->get('cart'), true);
            }
            else
            {
                $cart = [];
            }

            if (array_key_exists($product->getId(), $cart))
            {
                $qty += $cart[$product->getId()]['quantity'];
            }

            $cart[$product->getId()] = ['quantity' => $qty];

            $this->session->set('cart', json_encode($cart));
        }
    }

    /*
    public function supp(Product $product, $cart)
    {
        if($cart>0)
        {
            if ($this->session->get('cart'))
                $cart = json_decode($this->session->get('cart'), true);
        }
                else
                {
                    $cart=[];
                }
                if(array_key-exists($product->getId(),$cart))
                {
                $cart-=$cart[$product->getId()];
                 $cart[$product->getId()]
        }

    }  */

}