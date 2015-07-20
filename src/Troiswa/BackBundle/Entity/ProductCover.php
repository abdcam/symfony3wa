<?php

namespace Troiswa\BackBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ProductCover
 *
 * @ORM\Table(name="product_cover")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\ProductCoverRepository")
 * @ORM\HasLifecycleCallbacks
 */

class ProductCover
{
    /**
     * Cette fonction se lance avant le persit()
     * @ORM\PrePersist()
     */

    public function test()
    {
        //die('je suis ici');
    }

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @Assert\File(
     * maxSize = "1024k",
     * mimeTypes = {"application/pdf", "application/image/gif"}, mimeTypes =   {"application/image/jpeg", "application/image/gif"},
     * mimeTypesMessage = "Choisissez un fichier valide"
     * )
     */
    public $fichier;



    public function getFichier()
    {
        return $this->fichier;
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
     * Set name
     *
     * @param string $name
     * @return ProductCover
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return ProductCover
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

    private $oldFichier;



    public function setFichier(UploadedFile $fichier = null)
    {
        $this->fichier = $fichier; //ce fichier n'existe dans la base de donnée c'est un fichier cacché

        // Test si j'ai déjà une image
        if ($this->name) {
            // J'ajoute dans oldFichier l'ancienne image
            $this->oldFichier = $this->name;
            // Ajout de la ligne ci-dessous si l'on modifie uniquement l'image du produit
            // Modification du nom afin que doctrine lance le PreUpdate et le PostUpdate
            $this->name = null;
        }
        return $this;
    }

    /**
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Permet d'insérer un nom d'image au moment de la sauvegarde en BDD
        // Création d'un nom unique d'image
        $extension = $this->fichier->guessExtension();
        $this->name = str_replace(' ', '-', $this->alt) . uniqid().'.'.$extension;
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveImage()
    {
        //ici on met rien dans cette methode, elle charge les informations sur l'image
        //pour pouvoir supprimer.
        //dump($this);
        //die;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeImage()
    {
        // ../../../../web/uploads/product/nomimage.jpg
        // die("ici avant if");
        $imagePrincipale = $this->getAbsolutePath();
        //die(var_dump($this->getAbsolutePath(), file_exists($imagePrincipale)));
        if (file_exists($imagePrincipale))
        {
           // die("ici apres if");
            unlink($imagePrincipale);

        }

        // Supprimer les thumbnails

        $imageThumnail=$this->getAbsolutePath();

       if (file_exists($imageThumnail))
       {
           unlink($imageThumnail);
       }
    }


    //pour faire des images
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public  function upload()
    {

        //die("go pour upload");
        if (null==$this->fichier)
        {
            return ;
        }
        // Suppression des anciennes images
        //condition pour supprimer une et la remplacée par une autre
        if($this->oldFichier)
            {
                // Suppression des images

                // Suppression de l'image principale
                unlink($this->getUploadRootDir().'/'.$this->oldFichier);

                //Suppression des thumbnails
                foreach( $this->thumbnails as $key =>$value )
                {
                    unlink($this->getUploadRootDir() .'/'. $key.'-'. $this->oldFichier);
                }
            }

        /*
        $extension = $this->fichier->guessExtension();

        $nameImage = uniqid().".".$extension;
        $this->fichier->move($this->getuploadRootDir(),
            $nameImage);

        // Création des thumbnails
        // voir doc: http://imagine.readthedocs.org/en/latest/

        $this->name=$nameImage;
        */


        $this->fichier->move($this->getuploadRootDir(),
            $this->name);

        // Création des thumbnails
        $imagine = new \Imagine\Gd\Imagine();
        $imagineOpen = $imagine->open($this->getAbsolutePath());

        foreach($this->thumbnails as $key => $value)
        {
            $imagineOpen->thumbnail(new \Imagine\Image\Box($value[0], $value[1]))
                ->save(
                    $this->getUploadRootDir() . '/'.$key.'-' . $this->name);
        }
    }


    public function getAbsolutePath()
    {

        return $this->getUploadRootDir().'/'.$this->name;
    }

    public function getuploadRootDir()
    {
        return __DIR__."/../../../../web/upload/products_img";
    }


    public function getWebPath($size = null)
    {
        if (array_key_exists($size, $this->thumbnails))
        {
            return "upload/products_img/".$size.'-'.$this->name;
        }
        else
        {
            return "upload/products_img/".$this->name;
        }
    }

    private $thumbnails=
        [
            "thumb-small"=>[100,50],
            "thumb-medium"=>[500,500],
        ];

}
