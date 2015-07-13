<?php

namespace Troiswa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("title","text")
            ->add("description","textarea")
            ->add("prix")
            ->add("quantite","integer")
            ->add("active")
            //a été ajouté pour mettre les cat et ordonner avec position
            ->add("categ","entity",
                [
                    "class"=>"TroiswaBackBundle:Category",
                    "property"=> "title",
        "query_builder"=>function(EntityRepository $er)
            {
            return $er->createQueryBuilder("cat")
                        ->orderby("cat.position","ASC");
            }

                ]);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_product';
    }
}
