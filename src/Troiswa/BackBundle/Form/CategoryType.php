<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',"text")
            ->add('description')
            ->add('position')
            ->add('products', 'entity',
            [
                'class' => 'TroiswaBackBundle:Product',
                'property' => 'title',
                'multiple' => true, //permet de selectionner plusieur dans la liste
                "by_reference"=>false
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {

        return 'troiswa_backbundle_category';
    }

}
