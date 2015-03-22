<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Room
 * Représente les chambres de chaque hôtel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MCDH\HotelBundle\Entity\RoomRepository")
 */
class Room
{
    /**
     * @var integer Identifiant de la chambre
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Nom de la chambre
     *
     * @ORM\Column(name="name", type="string", length=15, nullable=false)
     * @Assert\NotBlank(message="La chambre doit porter un nom")
     * @Assert\Length(max=15, maxMessage="Le nom de la chambre ne doit pas dépasser {{ limit }} caractères")
     */
    private $name;

    /**
     * @var integer Etage de la chambre
     *
     * @ORM\Column(name="floor", type="integer")
     * @Assert\Range(min=0,minMessage="L'étage de la chambre doit être un entier positif ou nul.",invalidMessage="L'étage de la chambre doit être un entier positif ou nul")
     */
    private $floor;

    /**
     * @var integer Capacité d'accueil de la chambre
     *
     * @ORM\Column(name="people", type="integer", nullable=false)
     * @Assert\NotBlank(message="La chambre doit avoir un nombre de places défini")
     * @Assert\Range(min=1,minMessage="Le nombre de personnes doit être un entier positif ou nul.",invalidMessage="Le nombre de personnes doit être un entier positif ou nul.")
     */
    private $people;


    /**
     * @var string Orientation cardinale de la chambre
     *
     * @ORM\Column(name="orientation", type="string", length=10, nullable=false)
     * @Assert\NotBlank(message="La chambre doit avoir un nombre de places défini")
     * @Assert\Choice(choices={"north","south","east","west"}, message="La chambre peut avoir une orientation Nord, Sud, Est ou Ouest")
     */
    private $orientation;

    /**
     * @var decimal Prix d'une nuité
     *
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=false)
     * @Assert\NotBlank(message="La chambre doit avoir un prix.")
     * @Assert\Range(min=0,minMessage="Le prix est un nombre décimal positif.",invalidMessage="Le prix est un nombre décimal.")
     */
    private $price;
    
    /**
     * @var Hotel Hotel auquel appartient la chambre
     * 
     * @ORM\ManyToOne(targetEntity="MCDH\HotelBundle\Entity\Hotel")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     */
    private $hotel;
    
    /**
     * @var Image Image associée à la chambre
     * 
     * @ORM\OneToOne(targetEntity="MCDH\HotelBundle\Entity\Image", cascade={"persist"})
     */
    private $image;
    
    
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
     * @return Room
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
     * Set floor
     *
     * @param integer $floor
     * @return Room
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return integer 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set people
     *
     * @param integer $people
     * @return Room
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return integer 
     */
    public function getPeople()
    {
        return $this->people;
    }

      /**
     * Set orientation
     *
     * @param string $orientation
     * @return Room
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string 
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    

    /**
     * Set price
     *
     * @param integer $price
     * @return Room
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set hotel
     *
     * @param \MCDH\HotelBundle\Entity\Hotel $hotel
     * @return Room
     */
    public function setHotel(\MCDH\HotelBundle\Entity\Hotel $hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \MCDH\HotelBundle\Entity\Hotel 
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set image
     *
     * @param \MCDH\HotelBundle\Entity\Image $image
     * @return Room
     */
    public function setImage(\MCDH\HotelBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MCDH\HotelBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
