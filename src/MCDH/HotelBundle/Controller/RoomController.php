<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MCDH\HotelBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use MCDH\HotelBundle\Form\RoomType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * Contrôleur pour la gestion des chambres
 *
 */
class RoomController extends Controller{
	
	/**
	 * Ajouter une chambre
	 * Le propriétaire de l'hôtel ou l'administrateur peuvent executer cette fonction
	 * 
	 * @param int $idHotel
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_HOTELKEEPER')")
	 */
	public function addAction($idHotel, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		 
		//récupération dans la base de données de l'hôtel à supprimer
		$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
		 
		//affichage d'une erreur si l'hôtel n'existe pas
		if($hotel === null){
    		throw new NotFoundHttpException("Aucun hôtel ne porte l'identifiant ".$idHotel.".");
		}
		
    	//vérification que le propriétaire courant est soit le propriétaire, soit l'administrateur
		$hotelkeeper = $hotel->getHotelKeeper();
		$user = $this->getUser();
		if($user != $hotelkeeper or !$this->get('security.context')->isGranted('ROLE_ADMIN')){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette hôtel.");
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
		
		
		//sinon affichage du formulaire
		return $this->render('MCDHHotelBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
				'hotel' => $hotel
		));
	}
	
	/**
	 * Voir les détails d'une chambre
	 * Les détails de la chambre ainsi que les éventuelles réservations sont affichés
	 * Tous les utilisateurs peuvent accéder à cette fonction
	 * 
	 * @param unknown $idRoom
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($idRoom){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération dans la base de la chambre à afficher
		$room = $em->getRepository("MCDHHotelBundle:Room")->find($idRoom);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room === null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom.".");
		}
		
		//récupération de toutes les réservations futures de la chambre
		$bookings = $em->getRepository("MCDHHotelBundle:Booking")->findBy(array('room'=>$room));
		
		//affichage de la chambre
		return $this->render('MCDHHotelBundle:Room:view.html.twig', array(
				'room' => $room,
				'bookings' => $bookings
		));
		
	}

	/**
	 * Editer une chambre
	 * Le propriétaire de l'hôtel ou l'administrateur peuvent executer cette fonction
	 * 
	 * @param unknown $idRoom
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_HOTELKEEPER')")
	 */
	public function editAction($idRoom, Request $request){
		
		//récupération de l'Entity Mangager
		$em = $this->getDoctrine()->getManager();
		
		//récupération de la chmabre dans la base de données
		$room = $em->getRepository('MCDHHotelBundle:Room')->find($idRoom);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room === null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom.".");
		}
		
    	//vérification que le propriétaire courant est soit le propriétaire, soit l'administrateur
		$hotelkeeper = $room->getHotel()->getHotelKeeper();
		$user = $this->getUser();
		if($user != $hotelkeeper or !$this->get('security.context')->isGranted('ROLE_ADMIN')){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette chambre.");
		}
		
		//création du formulaire
		$form = $this->get('form.factory')->create(new RoomType(), $room);
		
		//si le formulaire est validé
		if($form->handleRequest($request)->isValid()){
			
			//flush de l'entité
			$em->flush();
			
			//affichage d'un message pour confirmer l'enregistrement des modifications
			$request->getSession()->getFlashBag()->add('notice','Les modifications de la chambre ont bien été prise en compte');
					
			//redirection vers la page affichant la chambre
			return $this->redirect($this->generateUrl('mcdh_hotel_view_room', array(
				'idRoom'=>$room->getId()
			)));
		}
		
		//sinon affichage du formulaire
		return $this->render('MCDHHotelBundle:Room:edit.html.twig', array(
			'form' => $form->createView(),
			'room' => $room
		));
	}
	
	/**
	 * Delete a room
	 * 
	 * @param int $idRoom
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction($idRoom, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération dans la base de données de la chambre à supprimer
		$room = $em->getRepository('MCDHHotelBundle:Room')->find($idRoom);
		
		//affichage d'une erreur si la chambre n'existe pas
		if($room === null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom.".");
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
			return $this->redirect($this->generateUrl('mcdh_hotel_view', array(
				'idHotel'=>$room->getHotel()->getId()
			)));
		}
		
		//sinon affichage du formulaire de validation
		return $this->render('MCDHHotelBundle:Room:delete.html.twig',array(
				'room'=>$room,
				'form'=>$form->createView()
		));
	}
}
