<?php

namespace Troiswa\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\FrontBundle\Entity\CommentRepository")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="Client")
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     * @Assert\NotBlank(message = "Commentaire obligatoire")
     */
    private $contenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     * @Assert\NotBlank(message = "Note obligatoire")
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Product")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="Comment")
     */
    private $parent;


    public function __construct()
    {
        $this->date = new \DateTime("now");
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
     * Set contenu
     *
     * @param string $contenu
     * @return Comment
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return Comment
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set client
     *
     * @param \Troiswa\FrontBundle\Entity\Client $client
     * @return Comment
     */
    public function setClient(\Troiswa\FrontBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Troiswa\FrontBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set produit
     *
     * @param \Troiswa\BackBundle\Entity\Product $produit
     * @return Comment
     */
    public function setProduit(\Troiswa\BackBundle\Entity\Product $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \Troiswa\BackBundle\Entity\Product 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set parent
     *
     * @param \Troiswa\FrontBundle\Entity\Comment $parent
     * @return Comment
     */
    public function setParent(\Troiswa\FrontBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Troiswa\FrontBundle\Entity\Comment 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
