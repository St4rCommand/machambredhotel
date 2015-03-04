<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\RoomBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;


class RoomController extends Controller{

	public function editAction($id){
	
	}
	
	public function addAction(Request $request){
		// On crée un objet room
		$room = new Room();
		
		// On crée le FormBuilder grâce au service form factory
		$formBuilder = $this->get('form.factory')->createBuilder('form', $room);
		
		// On ajoute les champs de l'entité que l'on veut à notre formulaire
		$formBuilder
		->add('name',      'text')
		->add('floor',     'integer')
		->add('price',    'text')
		->add('orientation', 'text')
		->add('person', 'integer')
		->add('save',      'submit')
		;
		
		// À partir du formBuilder, on génère le formulaire
		$form = $formBuilder->getForm();
		
		if($form->handleRequest($request)->isValid()){
			
			//on récup le manager
			$em = $this->getDoctrine()->getManager();
			
			
		//persistance de l'entité room (sauvegarder dans la base).
			
			$em->persist($room);
			
			$em->flush();
			
			return $this->redirect($this->generateUrl('mcdh_room_view',array('id' => $room->getId())));
			
		}
		
		
		// On passe la méthode createView() du formulaire à la vue
		// afin qu'elle puisse afficher le formulaire toute seule
		return $this->render('MCDHRoomBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function deleteAction($id){
		
	}
	
	public function viewAction($id){
		
		$repository = $this->getDoctrine()->getManager()->getRepository("MCDHRoomBundle:Room");
		$room = $repository->find($id);
		
		
		return $this->render('MCDHRoomBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
