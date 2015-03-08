<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\RoomBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use MCDH\RoomBundle\Form\RoomType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function editAction($id, Request $request){
		
		//récupération de la chmabre dans la base de données
		$room = $this->getDoctrine()->getManager()->getRepository('MCDHRoomBundle:Room')->find($id);
		
		//création du formulaire
		$form = $this->get('form.factory')->create(new RoomType(), $room);
		
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			
			//récupération de l'Entity Mangager
			$em = $this->getDoctrine()->getManager();
			
			//flush de l'entité
			$em->flush();
			
			//affichage d'un message pour confirmer l'enregistrement des modifications
			$request->getSession()->getFlashBag()->add('notice','Les modifications de la chambre ont bien été prise en compte');
					
			//redirection vers la page affichant la chambre
			return $this->redirect($this->generateUrl('mcdh_room_view', array(
				'id'=>$room->getId()
			)));
		}
		
		//affichage du formulaire d'édition d'une chambre
		return $this->render('MCDHRoomBundle:Room:edit.html.twig', array(
			'form' => $form->createView(),
			'room' => $room
		));
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
		
		
		//affichage du formulaire d'ajout d'une chambre
		return $this->render('MCDHRoomBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * Delete a room
	 * 
	 * @param unknown $id
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteAction($id, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération dans la base de données de la chambre à supprimer
		$room = $em->getRepository('MCDHRoomBundle:Room')->find($id);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room == null){
			throw $this->createNotFoundException("Aucune chambre ne porte l'identifiant ".$id);
		}
		
		//création d'un formulaire de validation
		$form = $this->createFormBuilder()
		->add('delete', 'submit')
		->getForm();
		
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			//suppression de la chambre
			$em->remove($room);
			$em->flush();
			
			//affichage d'un message pour confirmer la suppression de la chambre
			$request->getSession()->getFlashBag()->add('info', 'Chambre supprimée.');
			
			//retour à la page d'accueil
			return $this->redirect($this->generateUrl('mcdh_room_add'));
		}
		
		//affichage du formulaire de validation de suppression
		return $this->render('MCDHRoomBundle:Room:delete.html.twig',array(
				'room'=>$room,
				'form'=>$form->createView()
		));
	}
	
	/**
	 * View a room
	 * 
	 * @param unknown $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($id){
		
		//récupération dans la base de la chambre à afficher
		$room = $this->getDoctrine()->getManager()->getRepository("MCDHRoomBundle:Room")->find($id);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room == null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$id);
		}
		
		//affichage de la chambre demandée
		return $this->render('MCDHRoomBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
