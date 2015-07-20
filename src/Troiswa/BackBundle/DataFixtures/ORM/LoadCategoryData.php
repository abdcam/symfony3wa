<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Category;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadCategoryData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //die('prems');
        $category = new Category();

        $category->setTitle('ma categorie fixtures');
        $category->setDescription('lorem ipsum de ma categorie');
        $category->setPosition('{{ category.id }}');

        $manager->persist($category);
        $manager->flush();

        $this->addReference('refcat', $category);
    }

    public function getOrder()
    {
        return 1;
    }
}
