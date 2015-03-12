<?php

namespace MCDH\HotelBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MCDH\HotelBundle\Entity\Hotel;
use MCDH\HotelBundle\Entity\Room;

class LoadHotel implements FixtureInterface{
	
	public function load(ObjectManager $manager){
		
		//instanciation des hôtels
		$carlton = new Hotel();
		$carlton->setName("Carlton");
		$carlton->setAddress("3, rue de Paris");
		$carlton->setPostcode("59000");
		$carlton->setCity("Lille");
		$carlton->setCountry("France");
		$carlton->setEmail("contact@carltonlille.com");
		$carlton->setWebsite("http://www.carltonlille.com/index.php");
		$carlton->setPhoneNumber("0320133313");
		$carlton->setDescription("L'hôtel Carlton est situé en plein centre ville de Lille. Il vous propose 59 chambres et suites, des Salons de réceptions et des salles de séminaires. Cet hôtel de luxe 4 étoiles vous permet d'organiser vos repas d'affaires, cocktails ou banquets.");
		$carlton->setFloor("6");
		$carlton->setAddedDate(new \DateTime());

		$tribunal = new Hotel();
		$tribunal->setName("Hôtel du tribunal");
		$tribunal->setAddress("Place du tribunal");
		$tribunal->setPostcode("61400");
		$tribunal->setCity("Mortagne au Perche");
		$tribunal->setCountry("France");
		$tribunal->setEmail(" hotel.du.tribunal@wanadoo.fr");
		$tribunal->setWebsite("http://www.hotel-tribunal.fr/");
		$tribunal->setPhoneNumber("0233250477");
		$tribunal->setDescription("Hôtel - Restaurant dans une demeure des 13è et 18è siècles admirablement située au coeur du vieux Mortagne et des douces collines du Perche. A cheval, à pied, à vélo, de routes ombragées en sentiers balisés, de collines en prairies, de manoirs en haras, vous découvrirez notre belle région du Parc naturel Régional du Perche.");
		$tribunal->setFloor("3");
		$tribunal->setAddedDate(new \DateTime());
		
		$thebryantparkhotel = new Hotel();
		$thebryantparkhotel->setName("The Bryant Park Hotel");
		$thebryantparkhotel->setAddress("40 West 40th Street");
		$thebryantparkhotel->setPostcode("NY 10018");
		$thebryantparkhotel->setCity("New York");
		$thebryantparkhotel->setCountry("USA");
		$thebryantparkhotel->setEmail("info@bryantparkhotel.com");
		$thebryantparkhotel->setWebsite("http://www.bryantparkhotel.com/#!");
		$thebryantparkhotel->setPhoneNumber("2128690100");
		$thebryantparkhotel->setDescription("The Bryant Park Hotel has emerged since opening in 2001 as a “Designer Luxury Hotel” receiving countless awards for service and accommodations. The hotel caters to the fashion culturati, Hollywood and Film Industry, as well as cosmopolitans, both native and transient.");
		$thebryantparkhotel->setFloor("25");
		$thebryantparkhotel->setAddedDate(new \DateTime());
	
		$georgev = new Hotel();
		$georgev->setName("George V Paris");
		$georgev->setAddress("31 avenue George V");
		$georgev->setPostcode("75008");
		$georgev->setCity("Paris");
		$georgev->setCountry("France");
		$georgev->setEmail(null);
		$georgev->setWebsite("http://www.fourseasons.com/fr/paris/");
		$georgev->setPhoneNumber("0149527000");
		$georgev->setDescription("Des terrasses privées surplombant Paris, de splendides tapisseries du XVIIIe, un cadre enchanteur et élégant... À deux pas des Champs-Élysées, le Four Seasons Hotel George V Paris incarne le raffinement et l'excellence du service dans la Ville Lumière.");
		$georgev->setFloor("5");
		$georgev->setAddedDate(new \DateTime());
		
		$manager->persist($carlton);
		$manager->persist($georgev);
		$manager->persist($thebryantparkhotel);
		$manager->persist($tribunal);
		
		
		
		
		//instanciation des chambres
		$cComfort = new Room();
		$cComfort->setName("Comfort");
		$cComfort->setFloor(1);
		$cComfort->setPeople(2);
		$cComfort->setOrientation("ouest");
		$cComfort->setPrice(80);
		$cComfort->setHotel($tribunal);
		
		$cComfortplus = new Room();
		$cComfortplus->setName("Comfort +");
		$cComfortplus->setFloor(2);
		$cComfortplus->setPeople(2);
		$cComfortplus->setOrientation("ouest");
		$cComfortplus->setPrice(83);
		$cComfortplus->setHotel($tribunal);
		
		$cCharme = new Room();
		$cCharme->setName("Charme");
		$cCharme->setFloor(3);
		$cCharme->setPeople(2);
		$cCharme->setOrientation("ouest");
		$cCharme->setPrice(90);
		$cCharme->setHotel($tribunal);
		
		$manager->persist($cComfort);
		$manager->persist($cComfortplus);
		$manager->persist($cCharme);
		
		$manager->flush();
	}
	
}