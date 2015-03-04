<?php

namespace MCDH\RoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Room
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
     * @ORM\Column(name="nom", type="string", length=15)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="floor", type="integer")
     */
    private $floor;

    /**
     * @var integer
     *
     * @ORM\Column(name="person", type="integer")
     */
    private $person;



    /**
     * @var string
     *
     * @ORM\Column(name="orientation", type="string", length=10)
     */
    private $orientation;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    
    private $price;
    
    
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
     * @param string $name
     * @return Room
     */
    public function setName($name)
    {
        $this->nom = $name;

        return $this;
    }

    /**
     * Get nom
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
     * Set person
     *
     * @param integer $person
     * @return Room
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return integer 
     */
    public function getPerson()
    {
        return $this->person;
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
    public function setprice($price)
    {
    	$this->beds = $price;
    
    	return $this;
    }
    
    /**
     * Get price
     *
     * @return integer
     */
    public function getprice()
    {
    	return $this->price;
    }  
}
