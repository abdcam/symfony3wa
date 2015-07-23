<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('email',"email", [
                "constraints" => new Assert\Email(array(
                    'message' => "'{{ value }}' n'est pas un email valide.",
                    'checkMX' => true,
                ))])
            ->add('birthday')
            ->add('telephone')
            ->add('pseudo')
            ->add('adresse')
            ->add("roles", 'entity', [
                'class' => 'TroiswaBackBundle:role',
                'property' => 'name',
                'multiple' => true
            ])

            ->add('submit', 'submit');

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_user_edit';
    }
}
