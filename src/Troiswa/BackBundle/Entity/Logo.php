<?php

namespace Troiswa\BackBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * logo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\LogoRepository")
 */
class Logo
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="legende", type="string", length=255)
     */
    private $legende;


    private $filelogo;
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
     * Set nom
     *
     * @param string $nom
     * @return logo
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return logo
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set legende
     *
     * @param string $legende
     * @return logo
     */
    public function setLegende($legende)
    {
        $this->legende = $legende;

        return $this;
    }

    /**
     * Get legende
     *
     * @return string 
     */
    public function getLegende()
    {
        return $this->legende;
    }

    public function getFilelogo()
    {
        return $this->filelogo;
    }

    public function setFilelogo(UploadedFile $filelogo=null)
    {
        $this->filelogo=$filelogo;

        return $this;
    }

    //pour faire des images
    public  function upload()
    {
        //die("go pour upload");
        if (null==$this->filelogo)
        {
            return ;
        }
        $extension = $this->filelogo->guessExtension();

        $nameImage = uniqid().".".$extension;
        $this->filelogo->move($this->getuploadRootDir(),
            $nameImage);

        // Création des thumbnails
        // voir doc: http://imagine.readthedocs.org/en/latest/

        $this->nom=$nameImage;

        // Création des thumbnails
        $imagine = new \Imagine\Gd\Imagine();
        $imagine
            ->open($this->getAbsolutePath())
            ->thumbnail(new \Imagine\Image\Box(300, 200))
            ->save(
                $this->getUploadRootDir() . '/thumb-small-' . $this->name);
    }

    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().'/'.$this->nom;
    }

    public function getuploadRootDir()
    {
        return __DIR__."/../../../../web/upload/Logo_img";
    }
    public function getwebPath()
    {
        return "upload/Logo_img/".$this->nom;

    }


}
