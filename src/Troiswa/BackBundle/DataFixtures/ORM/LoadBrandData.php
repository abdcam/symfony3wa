<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Brand;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        //dump($this->getReference('refcat'));
        //die;

        $brand = new Brand();
        $brand->setTitle('Samsung');
        $brand->setDescription('le meilleur de son temps en promo');


        $manager->persist($brand);
        $manager->flush();

        $this->addReference('refbrand', $brand);
    }

    public function getOrder()
    {
        return 2;
    }
}
