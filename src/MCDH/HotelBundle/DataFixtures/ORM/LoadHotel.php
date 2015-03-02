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
				"name" => "Hôtel du tribunal",
				"address"=>"Place du tribunal",
				"postcode"=>"61400",
				"city"=>"Mortagne au Perche",
				"country"=>"France"),
			array(
				"name" => "The Bryant Park Hotel",
				"address"=>"40 West 40th Street",
				"postcode"=>"NY 10018",
				"city"=>"New York",
				"country"=>"USA"),
			array(
				"name" => "George V Paris",
				"address"=>"31 avenue George V",
				"postcode"=>"75008",
				"city"=>"Paris",
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