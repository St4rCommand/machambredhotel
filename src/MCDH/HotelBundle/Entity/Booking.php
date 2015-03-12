<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MCDH\HotelBundle\Entity\BookingRepository")
 */
class Booking
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
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="date")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     * @ORM\JoinColumn(nullable=false)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="people", type="integer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $people;

    /**
     * @var boolean
     *
     * @ORM\Column(name="breakfast", type="boolean")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breakfast;
    
    /**
     * @var Room
     * 
     * @ORM\ManyToOne(targetEntity="MCDH\HotelBundle\Entity\Room")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;


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
     * Set beginDate
     *
     * @param \DateTime $beginDate
     * @return Booking
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime 
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Booking
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Booking
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set people
     *
     * @param integer $people
     * @return Booking
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
     * Set breakfast
     *
     * @param boolean $breakfast
     * @return Booking
     */
    public function setBreakfast($breakfast)
    {
        $this->breakfast = $breakfast;

        return $this;
    }

    /**
     * Get breakfast
     *
     * @return boolean 
     */
    public function getBreakfast()
    {
        return $this->breakfast;
    }

    /**
     * Set room
     *
     * @param \MCDH\HotelBundle\Entity\Room $room
     * @return Booking
     */
    public function setRoom(\MCDH\HotelBundle\Entity\Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \MCDH\HotelBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }
}
