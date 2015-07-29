<?php

namespace Troiswa\FrontBundle\Twig;

class Extention extends \Twig_Extension
{
     // exemple pour les prix à cet format   {{ product.price|price(4,'.',"-") }}    => 100-000-000.00 €

      // pour age:  {{ age(user.birthday)  }}

    public function getFilters()
    {
        return
        [
            //'price' => new \Twig_Filter_Method($this, 'priceFilter'),
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
            'sexe' => new \Twig_Filter_Method($this, 'sexeFilter')
        ];
        //Nom du filter => $this : objet extension avec les informations de la donnée à filter
        // priceFilter est la méthode à executer
    }


    public function priceFilter($number, $decimal = 2, $separatorDecimal = ',',
                                $separatorMille = " ")
    {
        $price = number_format($number, $decimal, $separatorDecimal, $separatorMille);
        return $price." €";//permet de rajouter Euro au prix en faisant ca:{{ product.price|price }}
    }

    public function trunkFilter($texte,$nbr = 50)
    {

        return (strlen($texte) > $nbr ? substr(substr($texte,0,$nbr),0,strrpos(substr($texte,0,$nbr)," "))." ..." : $texte);

    }


    public function sexeFilter($sexe)
    {
        if($sexe)
            {
                $s="Homme";
            }
        else $s="Femme";

        return $s;

    }

    public function getFunctions()
    {
        return [];
    }

    public function getName()
    {
        return 'troiswa_front.twig.twig_extentions';
    }

    // pour calculer lage
    public function ageFunction($date)
    {
        $now = new \DateTime('now');
        $diff = $date->diff($now);
        return $diff->format('%y'). 'ans';
    }

}


