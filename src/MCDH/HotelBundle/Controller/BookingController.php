<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MCDH\HotelBundle\Form\BookingType;
use MCDH\HotelBundle\Entity\Booking;

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
	 */
	public function addAction($idRoom, Request $request){
		
		$em = $this->getDoctrine()->getManager();
		
		$room = $em->getRepository('MCDHHotelBundle:Room')->find($idRoom);
			
		if($room == null){
			throw $this->createNotFoundException("Vous ne pouvez pas faire une réservation pour une chambre qui n'existe pas !");
		}
		 
		$booking = new Booking();
		$booking->setRoom($room);
		 
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
		 
		if($form->handleRequest($request)->isValid()){
			 
			$em->persist($booking);
			$em->flush();
	
			$request->getSession()->getFlashBag()->add('notice','Votre annonce a bien été prise en compte.');
	
			return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array('idBooking' => $booking->getId())));
	
		}
		
		return $this->render('MCDHHotelBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
				'booking' => $booking
		));
		
	}
	
	/**
	 *
	 * View a booking
	 *
	 * @param unknown $idRoom
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($idBooking){
	
		//récupération dans la base de la chambre à afficher
		$booking = $this->getDoctrine()->getManager()->getRepository("MCDHHotelBundle:Booking")->find($idBooking);
	
		//affichage d'une erreur si la chambre n'existe pas
		if($booking == null){
			throw new NotFoundHttpException("Aucune réservation ne porte l'identifiant ".$idBooking);
		}
	
		return $this->render('MCDHHotelBundle:Booking:view.html.twig', array(
				'booking' => $booking
		));
	
	}
	
	/**
	 * Edit a booking
	 *
	 * @param unknown $idRoom
	 */
	public function editAction($idBooking, Request $request){
	
		$em = $this->getDoctrine()->getManager();
		$booking = $em->getRepository('MCDHHotelBundle:Booking')->find($idBooking);
	
		$form = $this->get('form.factory')->create(new BookingType(), $booking);
	
		//si le formulaire a été validé
		if($form->handleRequest($request)->isValid()){
				
			//flush de l'entité
			$em->flush();
				
			//affichage d'un message pour confirmer l'enregistrement des modifications
			$request->getSession()->getFlashBag()->add('notice','Les modifications de la réservation ont bien été prise en compte');
				
			//redirection vers la page affichant la chambre
			return $this->redirect($this->generateUrl('mcdh_hotel_view_booking', array(
					'idBooking'=>$booking->getId()
			)));
		}
	
		return $this->render('MCDHHotelBundle:Booking:edit.html.twig', array(
				'form' => $form->createView(),
				'booking' => $booking
		));
	}
		
}