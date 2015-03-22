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
 * Main controller for HotelBundle
 * 
 * @author Romain
 *
 */
class BookingController extends Controller
{
	
	/**
	 * Add a new booking
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function addAction($idRoom, Request $request){
		
		$em = $this->getDoctrine()->getManager();
		
		$room = $em->getRepository("MCDHHotelBundle:Room")->find($idRoom);
			
		if($room === null){
			throw new NotFoundHttpException("Aucune chambre ne porte l'identifiant ".$idRoom.".");
		}
		 
		$booking = new Booking();
		$booking->setRoom($room);
		$booking->setCustomer($this->getUser());
		$booking->setBeginDate(new \DateTime());
		$booking->setEndDate((new \DateTime())->add(new \DateInterval('P1D')));
		$booking->setPeople($booking->getRoom()->getPeople());
		$price = $booking->getEndDate()->diff($booking->getBeginDate())->format('days') * $booking->getRoom()->getPrice();
		$booking->setPrice($price);
		
		$bookings = $this->getDoctrine()->getManager()->getRepository("MCDHHotelBundle:Booking")->findFuturBookings($room);
		 
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
		 
		if($form->handleRequest($request)->isValid()){
			
			if($this->checkBookingValidity($bookings,$booking,$request)){
				$em->persist($booking);
				$em->flush();
		
				$request->getSession()->getFlashBag()->add('notice','Votre annonce a bien été prise en compte.');
		
				return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array('idBooking' => $booking->getId())));
			}
		}
		
		return $this->render('MCDHHotelBundle:Booking:add.html.twig', array(
				'form' => $form->createView(),
				'room' => $room,
				'bookings' => $bookings
		));
		
	}
	
	/**
	 *
	 * View a booking
	 *
	 * @param unknown $idRoom
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_CUSTOMER') or has_role('ROLE_HOTELKEEPER')")
	 */
	public function viewAction($idBooking){
		
		$em = $this->getDoctrine()->getManager();
	
		//récupération dans la base de la chambre à afficher
		$booking = $em->getRepository("MCDHHotelBundle:Booking")->find($idBooking);
	
		//affichage d'une erreur si la chambre n'existe pas
		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		
		$owner = $booking->getRoom()->getHotel()->getHotelKeeper();
		$customer = $booking->getCustomer();
		$user = $this->getUser();
		
		if($user != $owner and $user != $customer){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
	
		return $this->render('MCDHHotelBundle:Booking:view.html.twig', array(
				'booking' => $booking
		));
	
	}
	
	/**
	 * Edit a booking
	 *
	 * @param unknown $idRoom
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function editAction($idBooking, Request $request){
	
		$em = $this->getDoctrine()->getManager();
		$booking = $em->getRepository('MCDHHotelBundle:Booking')->find($idBooking);
		
		$customer = $booking->getCustomer();
		$user = $this->getUser();

		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		
		if($user != $customer){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
		
		$bookings = $this->getDoctrine()->getManager()->getRepository("MCDHHotelBundle:Booking")->findFuturBookings($booking->getRoom());
	
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
	
		if($form->handleRequest($request)->isValid()){

			$price = $booking->getEndDate()->diff($booking->getBeginDate())->format('days') * $booking->getRoom()->getPrice();
			$booking->setPrice($price);
			
			if($this->checkBookingValidity($bookings,$booking,$request)){
				$em->flush();
				$request->getSession()->getFlashBag()->add('notice','Les modifications de la réservation ont bien été prise en compte');
					
				return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array(
						'idBooking'=>$booking->getId()
				)));
			}
		}
	
		return $this->render('MCDHHotelBundle:Booking:edit.html.twig', array(
				'form' => $form->createView(),
				'booking' => $booking,
				'bookings' => $bookings
		));
	}
	
	/**
	 * Delete a booking
	 *
	 * @param unknown $idRoom
	 * @Security("has_role('ROLE_CUSTOMER')")
	 */
	public function deleteAction($idBooking, Request $request){
	
		$em = $this->getDoctrine()->getManager();
	
		$booking = $em->getRepository('MCDHHotelBundle:Booking')->find($idBooking);
		
		$customer = $booking->getCustomer();
		$user = $this->getUser();
	
		if($booking === null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking.".");
		}
		

		if($user != $customer){
			throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cette réservation.");
		}
	
		$form = $this->createFormBuilder()
		->add('delete', 'submit')
		->getForm();
	
		if($form->handleRequest($request)->isValid()){
			$em->remove($booking);
			$em->flush();
				
			$request->getSession()->getFlashBag()->add('info', 'Réservation annulée.');
				
			return $this->redirect($this->generateUrl('mcdh_hotel_view', array(
					'idHotel'=>$booking->getRoom()->getHotel()->getId()
			)));
		}
		
		return $this->render('MCDHHotelBundle:Booking:delete.html.twig',array(
				'booking'=>$booking,
				'form'=>$form->createView()
		));
	}
	
	/**
	 * Check if a booking is valid
	 * 
	 * @param bookings
	 * @param booking
	 * @param request
	 */
	private function checkBookingValidity($bookings, \MCDH\HotelBundle\Entity\Booking $booking, &$request){
		$valid = true;
		
		$begin = $booking->getBeginDate();
		$end = $booking->getEndDate();
		
		if($begin >= $end){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','La date de début doit être inférieure à la date de fin.');
		}
		
		if($begin < new \DateTime()){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Faille spacio temporelle : votre annonce commence dans le passé.');
		}
		
		if($begin->format('y') > (new \DateTime())->format('y')){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Vous ne pouvez pas réserver plus de 2 ans à l\'avance');
		}
		
		if($end->diff($begin)->format('days')>30){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Votre réservation ne peux pas avoir une durée supérieur à 30 jours');
		}
		
		if($booking->getPeople() > $booking->getRoom()->getPeople()){
			$valid = false;
			$request->getSession()->getFlashBag()->add('notice','Le nombre de personne dépasse la capacité de la chambre');
		}
		
		foreach($bookings as $b){
			$currentBegin = $b->getBeginDate();
			$currentEnd = $b->getEndDate();
			
			if(($begin>=$currentBegin and $begin < $currentEnd)
				or ($end >$currentBegin and $end <= $currentEnd)){
				$request->getSession()->getFlashBag()->add('notice','Date de réservation à cheval sur une autre réservation : veuillez choisir une autre date ou une autre chambre pour votre réservation.');
			}
		}
			
		return $valid;
	}
}