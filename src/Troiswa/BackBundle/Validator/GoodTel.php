<?php

namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class GoodTel extends Constraint
{
    public $message = "Mauvais numéro de téléphone.";

    public $max = 5;
}