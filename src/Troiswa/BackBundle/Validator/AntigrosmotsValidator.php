<?php
namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntigrosmotsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {


        // Créer un tableau de gros mots
        // Si la valeur tapé par l'utilisateur est dans le tableau
        // Création d'une erreur

        if ( preg_match("#\b(merde|con)\b#i",$value))
        {
            $this->context->addViolation($constraint->message);
        }

    }

}