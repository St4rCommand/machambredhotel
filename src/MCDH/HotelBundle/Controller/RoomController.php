<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\HotelBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use MCDH\HotelBundle\Form\RoomType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Main controller for HotelBundle
 * 
 * @author Simon
 *
 */
class RoomController extends Controller{

	/**
	 * Edit a room
	 * 
	 * @param unknown $idRoom
	 */
	public function editAction($idRoom, Request $request){
		
		//récupération de la chmabre dans la base de données
		$room = $this->getDoctrine()->getManager()->getRepository('MCDHHotelBundle:Room')->find($idRoom);
		
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
			return $this->redirect($this->generateUrl('mcdh_hotel_view_room', array(
				'idRoom'=>$room->getId()
			)));
		}
		
		return $this->render('MCDHHotelBundle:Room:edit.html.twig', array(
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
	public function addAction($idHotel, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		 
		//récupération dans la base de données de l'hôtel à supprimer
		$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
		 
		//affichage d'une erreur si l'hôtel n'existe pas
		if($hotel == null){
			throw $this->createNotFoundException("L'hôtel portant l'identifiant ".$idHotel." n'existe pas. ");
		}
		
		//création d'un objet room
		$room = new Room();
		$room->setHotel($hotel);
		
		//création du formulaire
		$form = $this->get('form.factory')->create(new RoomType(), $room);
		
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			
			//persistance de l'entité room (sauvegarder dans la base)
			$em->persist($room);
			
			$request->getSession()->getFlashBag()->add('notice','Chambre bien enregistrée.');
			
			//flush de l'entité
			$em->flush();
			
			
			//redirection vers la chambre ajoutée
			return $this->redirect($this->generateUrl('mcdh_hotel_view_room',array(
				'idRoom' => $room->getId())));
		}
		
		
		// On passe la méthode createView() du formulaire à la vue
		// afin qu'elle puisse afficher le formulaire toute seule
		return $this->render('MCDHHotelBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
				'hotel' => $hotel
		));
	}
	
	/**
	 * Delete a room
	 * 
	 * @param unknown $idRoom
	 */
	public function deleteAction($idRoom, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération dans la base de données de la chambre à supprimer
		$room = $em->getRepository('MCDHHotelBundle:Room')->find($idRoom);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room == null){
			throw $this->createNotFoundException("Aucune chambre ne porte l'identifiant ".$idRoom);
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
			return $this->redirect($this->generateUrl('mcdh_hotel_add_room', array(
				'idHotel'=>$idHotel
			)));
		}
		
		return $this->render('MCDHHotelBundle:Room:delete.html.twig',array(
				'room'=>$room,
				'form'=>$form->createView()
		));
	}
	
	/**
	 * 
	 * View a room
	 * 
	 * @param unknown $idRoom
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($idRoom){
		
		//récupération dans la base de la chambre à afficher
		$room = $this->getDoctrine()->getManager()->getRepository("MCDHHotelBundle:Room")->find($idRoom);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room == null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom);
		}
		
		return $this->render('MCDHHotelBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
