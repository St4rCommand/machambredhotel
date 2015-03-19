<?php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MCDH\UserBundle\Entity\User;

class LoadUser implements FixtureInterface{

	public function load(ObjectManager $manager){

		$adminUser = new User;
		$adminUser->setUserName('admin');				
		$adminUser->setPlainPassword('admin');
		$adminUser->setEmail('admin@mail.com');
		$adminUser->setEnabled(true);
		$adminUser->setRoles(array('ROLE_ADMIN'));
		$manager->persist($adminUser);
	    $manager->flush();
	    
	    $customerUser = new User;
	    $customerUser->setUserName('customer');
	    $customerUser->setPlainPassword('customer');
	    $customerUser->setEmail('customer@mail.com');
	    $customerUser->setEnabled(true);
	    $customerUser->setRoles(array('ROLE_CUSTOMER'));
	    $manager->persist($customerUser);
	    $manager->flush();
	    
	    $hotelKeeperUser = new User;
	    $hotelKeeperUser->setUserName('hotelkeeper');
	    $hotelKeeperUser->setPlainPassword('hotelkeeper');
	    $hotelKeeperUser->setEmail('hotelkeeper@mail.com');
	    $hotelKeeperUser->setEnabled(true);
	    $hotelKeeperUser->setRoles(array('ROLE_HOTELKEEPER'));
	    $manager->persist($hotelKeeperUser);
	    $manager->flush();

  }

}