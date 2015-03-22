<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use MCDH\UserBundle\MCDHUserBundle;

/**
 * Hotel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MCDH\HotelBundle\Entity\HotelRepository")
 */
class Hotel
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit porter un nom")
     * @Assert\Length(max=50, maxMessage="Le nom de l'hôtel ne doit pas dépasser {{ limit }} caractères.")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir une adresse.")
     * @Assert\Length(max=50, maxMessage="L'adresse de l'hôtel ne doit pas excéder {{ limit }} caractères.")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir un code postal.")
     * @Assert\Length(max=10, maxMessage="Le code postal de l'hôtel ne doit pas dépasser {{ limit }} caractères.")
     */
    private $postcode;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir une ville.")
     * @Assert\Length(max=50, maxMessage="La ville de l'hôtel ne doit pas dépasser {{ limit }} caractères.")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=25, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir un pays.")
     * @Assert\Length(max=25, maxMessage="Le pays de l'hôtel ne doit pas dépasser {{ limit }} caractères.")
     */
    private $country;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="added_date", type="date", nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir une date d'ajout.")
     * @Assert\Date()
     */
    private $addedDate;
    
   	/**
   	 * @var string
   	 * 
   	 * @ORM\Column(name="website", type="string", length=255, unique=true, nullable=true)
   	 * @Assert\Url(message="L'adresse du site internet de l'hôtel doit être une url valide")
   	 */
    private $website;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="phone_number", type="string", length=15, nullable=false)
     * @Assert\NotBlank(message="L'hôtel doit avoir un numéro de téléphone.")
     * @Assert\Length(max=15, maxMessage="Le numéro de téléphone de l'hôtel ne doit pas dépasser {{ limit }} caractères.")
     */
    private $phoneNumber;

    /**
     * @var string
     * 
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     * @Assert\Email(message="L'adresse email de l'hôtel doit être une adresse email valide")
     * @Assert\Length(max=255, maxMessage="L'adresse email ne doit pas dépasser 255 caractères")
     */
    private $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="text", length=500, nullable=false) 
     * @Assert\NotBlank(message="L'hôtel doit avoir une description.")
     * @Assert\Length(max=500, maxMessage="La description de l'hôtel ne doit pas dépasser {{ limit }} caractères")
     */
    private $description;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="floor", type="integer")
     * @Assert\Range(min=0,minMessage="Le nombre d'étages de l'hôtel doit être un entier positif ou nul",invalidMessage="Le nombre d'étages de l'hôtel doit être un entier positif ou nul")
     */
    private $floor;
    
    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="MCDH\HotelBundle\Entity\Image", cascade={"persist"})
     */
    private $image;
    
    /**
     * @var MCDH\UserBundle\Entity\User 
     * 
     * @ORM\ManyToOne(targetEntity="MCDH\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $hotelKeeper;
    
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
     * @return Hotel
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
     * Set address
     *
     * @param string $address
     * @return Hotel
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Hotel
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Hotel
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set addedDate
     *
     * @param \DateTime $addedDate
     * @return Hotel
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime 
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Hotel
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Hotel
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     * @return Hotel
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Hotel
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Hotel
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
     * Set floor
     *
     * @param integer $floor
     * @return Hotel
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
     * Set image
     *
     * @param \MCDH\HotelBundle\Entity\Image $image
     * @return Hotel
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

    /**
     * Set hotelKeeper
     *
     * @param \MCDH\UserBundle\Entity\User $hotelKeeper
     * @return Hotel
     */
    public function setHotelKeeper(\MCDH\UserBundle\Entity\User $hotelKeeper)
    {
        $this->hotelKeeper = $hotelKeeper;

        return $this;
    }

    /**
     * Get hotelKeeper
     *
     * @return \MCDH\UserBundle\Entity\User 
     */
    public function getHotelKeeper()
    {
        return $this->hotelKeeper;
    }
}
