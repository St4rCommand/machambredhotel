<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\RoomBundle\Entity\Room;


class RoomController extends Controller{

	public function editAction($id){
	
	}
	
	public function addAction(){
		// On crée un objet room
		$room = new Room();
		
		// On crée le FormBuilder grâce au service form factory
		$formBuilder = $this->get('form.factory')->createBuilder('form', $room);
		
		// On ajoute les champs de l'entité que l'on veut à notre formulaire
		$formBuilder
		->add('name',      'text')
		->add('floor',     'integer')
		->add('price',    'text')
		->add('orientation', 'choice')
		->add('person', 'integer')
		->add('save',      'submit')
		;
		
		// À partir du formBuilder, on génère le formulaire
		$form = $formBuilder->getForm();
		
		// On passe la méthode createView() du formulaire à la vue
		// afin qu'elle puisse afficher le formulaire toute seule
		return $this->render('MCDHRoomBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function deleteAction($id){
		
	}
	
	public function viewAction($id){
		
		$room = array(
			"num" => 203,
			"floor" => 2,
		);
		
		return $this->render('MCDHRoomBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
