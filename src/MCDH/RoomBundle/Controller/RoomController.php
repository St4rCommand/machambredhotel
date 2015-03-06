<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\RoomBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use MCDH\RoomBundle\Form\RoomType;

/**
 * Main controller for RoomBundle
 * 
 * @author Simon
 *
 */
class RoomController extends Controller{

	/**
	 * Edit a room
	 * 
	 * @param unknown $id
	 */
	public function editAction($id){
	
	}
	
	/**
	 * Add a room
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function addAction(Request $request){
		
		//création d'un objet room
		$room = new Room();
		
		//création du formulaire
		$form = $this->get('form.factory')->create(new RoomType(), $room);
		
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			
			//récupération de l'Entity Manager
			$em = $this->getDoctrine()->getManager();
			
			//persistance de l'entité room (sauvegarder dans la base)
			$em->persist($room);
			
			$request->getSession()->getFlashBag()->add('notice','Chambre bien enregistrée.');
			
			//flush de l'entité
			$em->flush();
			
			
			//redirection vers la chambre ajoutée
			return $this->redirect($this->generateUrl('mcdh_room_view',array('id' => $room->getId())));
		}
		
		
		// On passe la méthode createView() du formulaire à la vue
		// afin qu'elle puisse afficher le formulaire toute seule
		return $this->render('MCDHRoomBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Delete a room
	 * 
	 * @param unknown $id
	 */
	public function deleteAction($id){
		
	}
	
	/**
	 * 
	 * View a room
	 * 
	 * @param unknown $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($id){
		
		$repository = $this->getDoctrine()->getManager()->getRepository("MCDHRoomBundle:Room");
		$room = $repository->find($id);
		
		
		return $this->render('MCDHRoomBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
