<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="begin_date", type="date", nullable=false)
     * @Assert\NotBlank(message="La réservation doit avoir une date d'arrivée.")
     * @Assert\Date()
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     * @Assert\NotBlank(message="La réservation doit avoir une date de départ.")
     * @Assert\Date()
     */
    private $endDate;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price", type="decimal", scale=2, nullable=false)
     * @Assert\NotBlank(message="La chambre doit avoir un prix.")
     * @Assert\Range(min=0,minMessage="Le prix est un nombre décimal positif.",invalidMessage="Le prix est un nombre décimal.")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="people", type="integer", nullable=false)
     * @Assert\NotBlank(message="La chambre doit avoir un nombre de places défini")
     * @Assert\Range(min=1,minMessage="Le nombre de personnes doit être un entier positif ou nul.",invalidMessage="Le nombre de personnes doit être un entier positif ou nul.")
     */
    private $people;

    /**
     * @var boolean
     *
     * @ORM\Column(name="breakfast", type="boolean", nullable=false)
     */
    private $breakfast;
    
    /**
     * @var Room
     * 
     * @ORM\ManyToOne(targetEntity="MCDH\HotelBundle\Entity\Room")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $room;
    
    /**
     * @var MCDH\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MCDH\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $customer;


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

    /**
     * Set customer
     *
     * @param \MCDH\UserBundle\Entity\User $customer
     * @return Booking
     */
    public function setCustomer(\MCDH\UserBundle\Entity\User $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MCDH\UserBundle\Entity\User 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
