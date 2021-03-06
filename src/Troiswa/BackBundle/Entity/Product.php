<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="title", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "100",
     *      maxMessage = "Le titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     *@Assert\Length(
     *      max = "100",
     *      maxMessage = "Le titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255)
     * @Assert\NotBlank()
     *  @Assert\Length(
     *      max = "10",
     *      maxMessage = "Le prix ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     * message="Le prix doit etre supéreur à 0 "
     *)
     */
    private $quantite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message="La quantité doit etre supéreur à 0"
     * )
     */
    private $active;

    /**
     * @Gedmo\Slug(fields={"title"},updatable=true)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;


    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Category",inversedBy="products")
     * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id")
     * */
    private $categ;

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Brand",inversedBy="products")
     * @ORM\JoinColumn(name="id_brand",referencedColumnName="id", nullable=true)
     * */
    private $ProduitMarque;

    /**
    * @ORM\OneToOne(targetEntity="ProductCover", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="id_productcover",referencedColumnName="id")
    *
    */
    private $cover;

    /** @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\Tag")
     *  @ORM\JoinTable(name="product_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_tag", referencedColumnName="id")
     *   }
     * )
     */
    private $tag;

    /**
     * pour faire activer en auto
     */
    public function __construct()
    {
        $this->active=true;//php app/console doctrine:generate:entities TroiswaBackBundle:Product
    }

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
     * @return Product
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
     * @return Product
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
     * Set prix
     *
     * @param string $prix
     * @return Product
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Product
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Product
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Set categ
     *
     * @param \Troiswa\BackBundle\Entity\Category $categ
     * @return Product
     */
    public function setCateg(\Troiswa\BackBundle\Entity\Category $categ = null)
    {
        $this->categ = $categ;

        return $this;
    }

    /**
     * Get categ
     *
     * @return \Troiswa\BackBundle\Entity\Category 
     */
    public function getCateg()
    {
        return $this->categ;
    }

    /**
     * Set ProduitMarque
     *
     * @param \Troiswa\BackBundle\Entity\Brand $produitMarque
     * @return Product
     */
    public function setProduitMarque(\Troiswa\BackBundle\Entity\Brand $produitMarque = null)
    {
        $this->ProduitMarque = $produitMarque;

        return $this;
    }

    /**
     * Get ProduitMarque
     *
     * @return \Troiswa\BackBundle\Entity\Brand 
     */
    public function getProduitMarque()
    {
        return $this->ProduitMarque;
    }

    /**
     * Set cover
     *
     * @param \Troiswa\BackBundle\Entity\ProductCover $cover
     * @return Product
     */
    public function setCover(\Troiswa\BackBundle\Entity\ProductCover $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \Troiswa\BackBundle\Entity\ProductCover 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Add tag
     *
     * @param \Troiswa\BackBundle\Entity\Tag $tag
     * @return Product
     */
    public function addTag(\Troiswa\BackBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Troiswa\BackBundle\Entity\Tag $tag
     */
    public function removeTag(\Troiswa\BackBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
