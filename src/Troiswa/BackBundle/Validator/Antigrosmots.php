<?php

namespace Troiswa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antigrosmots extends Constraint
{
    public $message = "Un gros mot est présent.";
}