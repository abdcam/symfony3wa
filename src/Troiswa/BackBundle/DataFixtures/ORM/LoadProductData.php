<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setTitle('mon super produit fixtures');
        $product->setDescription('lorem ipsum');
        $product->setPrix('250 Euros');
        $product->setQuantite('20');
        $product->setActive('true');

        $manager->persist($product);
        $manager->flush();
    }
}
