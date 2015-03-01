<?php

namespace MCDH\HotelBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MCDH\HotelBundle\Entity\Hotel;

class LoadHotel implements FixtureInterface{
	
	public function load(ObjectManager $manager){
		
		$hotels = array(
			array(
				"name" => "Carlton",
				"address"=>"3, rue de Paris",
				"postcode"=>"59000",
				"city"=>"Lille",
				"country"=>"France"),
			array(
					"name" => "Les Pieds dans l'Eau",
					"address"=>"28, chemin de la Folle Entreprise",
					"postcode"=>"61400",
					"city"=>"Saint-Langis-lès-Mortagne",
					"country"=>"France")
		);
		
		foreach ($hotels as $hotel){
			
			$h = new Hotel();
			
			$h->setName($hotel['name']);
			$h->setAddress($hotel['address']);
			$h->setPostcode($hotel['postcode']);
			$h->setCity($hotel['city']);
			$h->setCountry($hotel['country']);
			$h->setAddedDate(new \DateTime());
			
			$manager->persist($h);
		}
		
		$manager->flush();
	}
	
}