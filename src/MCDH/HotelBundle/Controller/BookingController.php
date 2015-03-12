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
	
			//return $this->redirect($this->generateUrl('mcdh_hotel_view', array('idHotel' => $hotel->getId())));
	
		}
		
		return $this->render('MCDHHotelBundle:Room:add.html.twig', array(
				'form' => $form->createView(),
				'booking' => $booking
		));
		
	}
		
}