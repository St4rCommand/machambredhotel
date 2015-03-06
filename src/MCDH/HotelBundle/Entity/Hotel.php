<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\Tests\String;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Config\Definition\IntegerNode;

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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=25)
     */
    private $country;
    
    /**
     * @var date
     * 
     * @ORM\Column(name="added_date", type="date")
     */
    private $added_date;
    
   	/**
   	 * @var string
   	 * 
   	 * @ORM\Column(name="website", type="string", length=255, unique=true, nullable=true)
   	 */
    private $website;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="phone", type="string", length=15, nullable=true)
     */
    private $phone_number;

    /**
     * @var string
     * 
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="text", length=500)
     */
    private $description;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="floor", type="integer")
     */
    private $floor;

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
     * Set added_date
     *
     * @param \DateTime $addedDate
     * @return Hotel
     */
    public function setAddedDate($addedDate)
    {
        $this->added_date = $addedDate;

        return $this;
    }

    /**
     * Get added_date
     *
     * @return \DateTime 
     */
    public function getAddedDate()
    {
        return $this->added_date;
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
     * Set phone_number
     *
     * @param integer $phoneNumber
     * @return Hotel
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phone_number
     *
     * @return integer 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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
}
