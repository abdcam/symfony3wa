<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("first", "text", ["constraints" => new Assert\Length(array("min" => 2,
            "max" => 2, "minMessage" => "Votre nom doit faire au moins {{ limit }} caractères",
            "maxMessage" => "Votre nom ne peut pas être plus long que {{ limit }} caractères"
        ))])
            ->add("lastname", "text", ["constraints" => new Assert\Length(array("max" => 5))])
            ->add("sujet", "choice", ["choices" => ["technique", "commercial", "partenariat"]])
            ->add("email", "email", [
                "constraints" => new Assert\Email(array(
                    'message' => "'{{ value }}' n'est pas un email valide.",
                    'checkMX' => true,
                ))])
            ->add("cotenu", "textarea", ["constraints" => new Assert\Length(array("min" => 1, "max" => 50))])
            ->add("button", "submit");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    public function getName()
    {
        return 'form_contact';
    }
}