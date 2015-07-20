<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Product;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        //dump($this->getReference('refcat'));
        //die;

        $product = new Product();
        $product->setTitle('mon super produit fixtures');
        $product->setDescription('lorem ipsum');
        $product->setPrix('250 Euros');
        $product->setQuantite('20');
        $product->setActive('true');

        $product->setCateg($this->getReference('refcat'));
        $product->setProduitMarque($this->getReference('refbrand'));

        $manager->persist($product);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
