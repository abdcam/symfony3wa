<?php
namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GoodTelValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        //dump($value);
        //die;
        // Créer un tableau de gros mots
        // Si la valeur tapé par l'utilisateur est dans le tableau
        // Création d'une erreur

        if (!preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#",$value))
        {
            $constraint->max;
            $this->context->addViolation($constraint->message);
        }

    }

}