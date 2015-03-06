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
				"country"=>"France",
				"email"=>"contact@carltonlille.com",
				"website"=>"http://www.carltonlille.com/index.php",
				"phone_number"=>"0320133313",
				"description"=>"L'hôtel Carlton est situé en plein centre ville de Lille. Il vous propose 59 chambres et suites, des Salons de réceptions et des salles de séminaires. Cet hôtel de luxe 4 étoiles vous permet d'organiser vos repas d'affaires, cocktails ou banquets.",
				"floor"=>"6"
			),
			array(
				"name" => "Hôtel du tribunal",
				"address"=>"Place du tribunal",
				"postcode"=>"61400",
				"city"=>"Mortagne au Perche",
				"country"=>"France",
				"email"=>" hotel.du.tribunal@wanadoo.fr",
				"website"=>"http://www.hotel-tribunal.fr/",
				"phone_number"=>"0233250477",
				"description"=>"Hôtel - Restaurant dans une demeure des 13è et 18è siècles admirablement située au coeur du vieux Mortagne et des douces collines du Perche. A cheval, à pied, à vélo, de routes ombragées en sentiers balisés, de collines en prairies, de manoirs en haras, vous découvrirez notre belle région du Parc naturel Régional du Perche.",
				"floor"=>"3"
			),
			array(
				"name" => "The Bryant Park Hotel",
				"address"=>"40 West 40th Street",
				"postcode"=>"NY 10018",
				"city"=>"New York",
				"country"=>"USA",
				"email"=>"info@bryantparkhotel.com",
				"website"=>"http://www.bryantparkhotel.com/#!",
				"phone_number"=>"2128690100",
				"description"=>"The Bryant Park Hotel has emerged since opening in 2001 as a “Designer Luxury Hotel” receiving countless awards for service and accommodations. The hotel caters to the fashion culturati, Hollywood and Film Industry, as well as cosmopolitans, both native and transient.",
				"floor"=>"25"
			),
			array(
				"name" => "George V Paris",
				"address"=>"31 avenue George V",
				"postcode"=>"75008",
				"city"=>"Paris",
				"country"=>"France",
				"email"=>null,
				"website"=>"http://www.fourseasons.com/fr/paris/",
				"phone_number"=>"0149527000",
				"description"=>"Des terrasses privées surplombant Paris, de splendides tapisseries du XVIIIe, un cadre enchanteur et élégant... À deux pas des Champs-Élysées, le Four Seasons Hotel George V Paris incarne le raffinement et l'excellence du service dans la Ville Lumière.",
				"floor"=>"5"
			)
		);
		
		foreach ($hotels as $hotel){
			
			$h = new Hotel();
			
			$h->setName($hotel['name']);
			$h->setAddress($hotel['address']);
			$h->setPostcode($hotel['postcode']);
			$h->setCity($hotel['city']);
			$h->setCountry($hotel['country']);
			$h->setAddedDate(new \DateTime());
			$h->setWebsite($hotel['website']);
			$h->setEmail($hotel['email']);
			$h->setPhoneNumber($hotel['phone_number']);
			$h->setDescription($hotel['description']);
			$h->setFloor($hotel['floor']);
			
			$manager->persist($h);
		}
		
		$manager->flush();
	}
	
}