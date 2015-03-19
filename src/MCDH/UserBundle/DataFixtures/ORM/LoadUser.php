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

  }

}