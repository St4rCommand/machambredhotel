<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MCDH\HotelBundle\Form\BookingType;
use MCDH\HotelBundle\Entity\Booking;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Contrôleur pour la gestion des réservations
 *
 */
class BookingController extends Controller
{
	
	/**
	 * Ajouter une réservation
	 * Les clients peuvent executer cette fonction
	 *
	 * @param int $idRoom
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function addAction($idRoom, Request $request){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération de la chambre
		$room = $em->getRepository("MCDHHotelBundle:Room")->find($idRoom);
			
		//affichage d'une erreur si la chambre n'existe pas
		if($room === null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom.".");
		}
		 
		//instanciation de la nouvelle réservation et paramétrage
		$booking = new Booking();
		$booking->setRoom($room);
		$booking->setCustomer($this->getUser());
		$booking->setBeginDate(new \DateTime());
		$booking->setEndDate((new \DateTime())->add(new \DateInterval('P1D')));
		$booking->setPeople($booking->getRoom()->getPeople());
		$price = $booking->getEndDate()->diff($booking->getBeginDate())->format('days') * $booking->getRoom()->getPrice();
		$booking->setPrice($price);
		
		//recherches des réservations existantes
		$bookings = $em->getRepository("MCDHHotelBundle:Booking")->findFuturBookings($room);
		
		//création du formulaire
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
		 
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			
			//si les données saisies sont valides
			if($this->checkBookingValidity($bookings,$booking,$request)){
				
				//sauvegarde de la réservation dans la base de données
				$em->persist($booking);
				$em->flush();
		
				//affichage d'un message de confirmation
				$request->getSession()->getFlashBag()->add('notice','Votre annonce a bien été prise en compte.');
		
				//redirection vers la réservation créée
				return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array('idBooking' => $booking->getId())));
			}
		}
		
		//sinon affichage du formulaire
		return $this->render('MCDHHotelBundle:Booking:add.html.twig', array(
				'form' => $form->createView(),
				'room' => $room,
				'bookings' => $bookings
		));
		
	}
	
	/**
	 * Voir les détails d'une réservation
	 * Seul le client et le propriétaire peuvent executer cette fonction (gestion du cas où d'autres rôles auraient été ajoutés)
	 *
	 * @param int $idBooking
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER') or has_role('ROLE_HOTELKEEPER')")
	 */
	public function viewAction($idBooking){
		
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
	
		//récupération dans la base de la réservation à afficher
		$booking = $em->getRepository("MCDHHotelBundle:Booking")->find($idBooking);
	
		//affichage d'une erreur si la réservation n'existe pas
		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		
		//vérification de l'identité de la personne connectée
		$owner = $booking->getRoom()->getHotel()->getHotelKeeper();
		$customer = $booking->getCustomer();
		$user = $this->getUser();
		if($user != $owner and $user != $customer or !$this->get('security.context')->isGranted('ROLE_ADMIN')){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
	
		//affichage de la réservation
		return $this->render('MCDHHotelBundle:Booking:view.html.twig', array(
				'booking' => $booking
		));
	
	}
	
	/**
	 * Editer une réservation
	 * Seul le client peut modifier sa réservation
	 *
	 * @param unknown $idBooking
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function editAction($idBooking, Request $request){
	
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
		
		//récupération de la réservation
		$booking = $em->getRepository('MCDHHotelBundle:Booking')->find($idBooking);
		
		//affichage d'une erreur si la réservation n'existe pas
		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		
		//vérification de l'identité du client
		$customer = $booking->getCustomer();
		$user = $this->getUser();
		if($user != $customer or !$this->get('security.context')->isGranted('ROLE_ADMIN')){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
		
		//recherches des réservations existantes
		$bookings = $this->getDoctrine()->getManager()->getRepository("MCDHHotelBundle:Booking")->findFuturBookings($booking->getRoom());
	
		//création du formulaire
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
	
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){

			//calcul du nouveau prix de la réservation
			$price = $booking->getEndDate()->diff($booking->getBeginDate())->format('days') * $booking->getRoom()->getPrice();
			$booking->setPrice($price);
			
			//si les données saisie sont valides
			if($this->checkBookingValidity($bookings,$booking,$request)){
				
				//prise en compte des modifications
				$em->flush();
				
				//redirection vers la réservation
				$request->getSession()->getFlashBag()->add('notice','Les modifications de la réservation ont bien été prise en compte');
					
				return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array(
						'idBooking'=>$booking->getId()
				)));
			}
		}
	
		//affichage du formulaire
		return $this->render('MCDHHotelBundle:Booking:edit.html.twig', array(
				'form' => $form->createView(),
				'booking' => $booking,
				'bookings' => $bookings
		));
	}
	
	/**
	 * Supprimer une réservation
	 * Seul le client peut annuler sa réservation
	 *
	 * @param unknown $idRoom
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function deleteAction($idBooking, Request $request){
	
		//récupération de l'Entity Manager
		$em = $this->getDoctrine()->getManager();
	
		//récupération de la réservation
		$booking = $em->getRepository('MCDHHotelBundle:Booking')->find($idBooking);
	
		//affichage d'une erreur si la réservation n'existe pas
		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		
		//vérification de l'identité du client
		$customer = $booking->getCustomer();
		$user = $this->getUser();
		if($user != $customer or !$this->get('security.context')->isGranted('ROLE_ADMIN')){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
	
		//création du formulaire de validation
		$form = $this->createFormBuilder()
		->add('delete', 'submit')
		->getForm();
	
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
			
			//suppression de la réservation
			$em->remove($booking);
			$em->flush();
			
			//message de confirmation de la suppression
			$request->getSession()->getFlashBag()->add('info', 'Réservation annulée.');
			
			//redirection vers la page affichant l'hôtel
			return $this->redirect($this->generateUrl('mcdh_hotel_view', array(
					'idHotel'=>$booking->getRoom()->getHotel()->getId()
			)));
		}
		
		//affichage du formulaire de validation 
		return $this->render('MCDHHotelBundle:Booking:delete.html.twig',array(
				'booking'=>$booking,
				'form'=>$form->createView()
		));
	}
	
	/**
	 * Vérification de la validité des données du formulaire
	 * 
	 * @param MCDH\HotelBundle\Entity\Booking $bookings
	 * @param MCDH\HotelBundle\Entity\Booking $booking
	 * @param Request $request
	 */
	private function checkBookingValidity($bookings, \MCDH\HotelBundle\Entity\Booking $booking, &$request){
		$valid = true;
		
		//récupération de la date de début et de la date de fin
		$begin = $booking->getBeginDate();
		$end = $booking->getEndDate();
		
		//date de début avant la date de fin
		if($begin >= $end){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','La date de début doit être inférieure à la date de fin.');
		}
		
		//réservation ne commence pas dans le passé
		if($begin < new \DateTime()){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Faille spacio temporelle : votre annonce commence dans le passé.');
		}
		
		//réservation n'est pas pour dans plus de 2 ans
		if($begin->format('y') > (new \DateTime())->format('y')){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Vous ne pouvez pas réserver plus de 2 ans à l\'avance');
		}
		
		//réservation ne dure pas plus de 30 jours
		if($end->diff($begin)->format('days')>30){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Votre réservation ne peux pas avoir une durée supérieur à 30 jours');
		}
		
		//réservation correspond à la capacité de la chambre
		if($booking->getPeople() > $booking->getRoom()->getPeople()){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Le nombre de personne dépasse la capacité de la chambre');
		}
		
		//réservation n'est pas à cheval sur une autre réservation
		foreach($bookings as $b){
			$currentBegin = $b->getBeginDate();
			$currentEnd = $b->getEndDate();
			
			if(($begin>=$currentBegin and $begin < $currentEnd)
				or ($end >$currentBegin and $end <= $currentEnd)){
				$request->getSession()->getFlashBag()->add('notice','Date de réservation à cheval sur une autre réservation : veuillez choisir une autre date ou une autre chambre pour votre réservation.');
				$valid = false;
			}
		}
			
		return $valid;
	}
}