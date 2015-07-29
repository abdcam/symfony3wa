<?php

namespace Troiswa\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troiswa\FrontBundle\Entity\CommentRepository;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // l'object comment est dans $builder->getData()
        //dump($builder->getData());
        //die;
        //le chemin d'acceder à l'id du produit
        $comment = $builder->getData();
        $idProduct = $comment->getProduit()->getId();
        //dump($idProduct);
       // die;

        $builder
          //  ->add('parent','entity', [
             //   'class' => 'TroiswaFrontBundle:Comment',
              //  'choice_label' => 'id'
           // ])

          ->add('parent',"entity",
              [
                  "class"=>"TroiswaFrontBundle:Comment",
                  "property" => "id",
                  "query_builder" => function(CommentRepository $er) use($idProduct)
                  {

                      return $er->findAllCommentOfOneProduct($idProduct);
                  }
                ])
            ->add('note', 'integer')
            ->add('contenu', 'textarea', [
                'label' => 'Commentaire :',
                'attr' => [
                    'placeholder' => 'Entrez votre commentaire ici'
                ]
            ])

        ;



            //->add('date')
           // ->add('client')
            //->add('produit')


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\FrontBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_frontbundle_comment';
    }
}
