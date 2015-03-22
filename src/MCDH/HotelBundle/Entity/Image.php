<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 * Représente les fichiers images uploadés
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MCDH\HotelBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var integer Identifiant de l'image
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Extension de l'image
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string Texte de remplacement de l'image
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    private $file;
    private $tempFilename;

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
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
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
     * Get file
     * 
     * @return File
     */
	public function getFile() {
		return $this->file;
	}
	
	/**
	 * Set file
	 * 
	 * @param unknown $file
	 * @return \MCDH\HotelBundle\Entity\Image
	 */
	public function setFile(UploadedFile $file)
	{
		$this->file = $file;
	
		if (null !== $this->extension) {
			$this->tempFilename = $this->extension;
	
			$this->extension = null;
			$this->alt = null;
		}
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if (null === $this->file) {
			return;
		}
	
		$this->extension = $this->file->guessExtension();
	
		$this->alt = $this->file->getClientOriginalName();
	}
	
	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if (null === $this->file) {
			return;
		}
	
		if (null !== $this->tempFilename) {
			$oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
			if (file_exists($oldFile)) {
				unlink($oldFile);
			}
		}
	
		$this->file->move(
				$this->getUploadRootDir(), // Le répertoire de destination
				$this->id.'.'.$this->extension   // Le nom du fichier à créer, ici « id.extension »
		);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function preRemoveUpload()
	{
		$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
	}
	
	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		if (file_exists($this->tempFilename)) {
			// On supprime le fichier
			unlink($this->tempFilename);
		}
	}
	
	public function getUploadDir()
	{
		return 'uploads/img';
	}
	
	protected function getUploadRootDir()
	{
		// On retourne le chemin relatif vers l'image pour notre code PHP
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
}
