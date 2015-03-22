<?php

namespace MCDH\HotelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends EntityRepository
{
	/**
	 * Sélectionner l'ensemble des réservations pour une chambre ayant une date de début supérieur à la date du jour
	 * 
	 * @param MCDH\HotelBundle\Entity\Room $room
	 * @return multitype:
	 */
	public function findFuturBookings($room){
		$query = $this->createQueryBuilder('b')

			->where('b.beginDate >= :today')
				->setParameter('today', new \DateTime())
				
			->andWhere('b.room = :room')
				->setParameter('room', $room)
			
			->orderBy('b.beginDate', 'ASC')
			->getQuery();
		
		return $query->getResult();
	}
	
	/**
	 * Sélectionner l'ensemble des réservations pour une chambre ayant une date de début supérieur à la date du jour
	 * 
	 * @param MCDH\HotelBundle\Entity\Room $room
	 * @return multitype:
	 */
	public function findUserBookings($user){
		$query = $this->createQueryBuilder('b')

			->where('b.beginDate >= :today')
				->setParameter('today', new \DateTime())
				
			->andWhere('b.customer = :customer')
				->setParameter('customer', $user)
			
			->orderBy('b.beginDate', 'ASC')
			->getQuery();
		
		return $query->getResult();
	}
}