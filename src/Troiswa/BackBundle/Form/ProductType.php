<?php

namespace Troiswa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troiswa\BackBundle\Repository\CategoryRepository;

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
                /*
            ->add("categ","entity",
                [
                    "class"=>"TroiswaBackBundle:Category",
                    "property"=> "title",
        "query_builder"=>function(CategoryRepository $er)
            {
            return $er->createQueryBuilder("cat")
                        ->orderby("cat.position","ASC");

                return $er->findPositionCategoryForFormType();
            }])
                */

            /*
            ->add('produitMarque', 'entity',
                [
            'class' => 'TroiswaBackBundle:Brand',
                'property' => 'title',
                "by_reference"=>false])
            */
            ->add("cover", new ProductCoverType());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
