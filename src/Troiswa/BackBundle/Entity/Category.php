<?php

namespace Troiswa\BackBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Product",mappedBy="categ")
     *
     */
    private $products;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

   

    /**
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function __toString()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \Troiswa\BackBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\Troiswa\BackBundle\Entity\Product $products)
    {
       $this->products[] = $products;

        //dump($products);
       // die();
        $products -> setCateg($this);

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Troiswa\BackBundle\Entity\Product $products
     */
    public function removeProduct(\Troiswa\BackBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
        $products->setCateg(null);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @Assert\True (message="categorie invalide")
     *
     */
    //pour valider un formulaire
    public function isCategoryValid()
    {
        if ($this->position==0 && $this->title!="accueil" )
        {
            return false;
        }
        return true;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->title!=ucfirst($this->title))
        {
            $context->buildViolation("Le titre {{ value }} doit commencer en majuscule !")
                    ->atPath("title")
                    ->setParameter("{{ value }}",$this->title )
                    ->addViolation();
        }
    }


}
