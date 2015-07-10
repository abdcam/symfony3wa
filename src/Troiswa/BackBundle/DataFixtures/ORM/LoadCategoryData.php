<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setTitle('ma categorie fixtures');
        $category->setDescription('lorem ipsum de ma categorie');
        $category->setPosition('{{ category.id }}');

        $manager->persist($category);
        $manager->flush();
    }
}
