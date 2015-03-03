<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MCDH\HotelBundle\Entity\Hotel;
use MCDH\HotelBundle\Form\HotelType;

/**
 * Main controller for HotelBundle
 * 
 * @author Romain
 *
 */
class HotelController extends Controller
{
	/**
	 * Homepage for HotelBundle
	 * 
	 * @param unknown $page
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction($page)
    {
    	//si la page demandée n'existe pas
    	if ($page < 1) {
    	
    		//exception levée
    		throw new NotFoundHttpException('Page "'.$page.'" inexistante.'); // Traduction ?
    	}

    	$hotels = $this
    		->getDoctrine()
    		->getManager()
    		->getRepository('MCDHHotelBundle:Hotel')
    		->findAll();
    	
    	if (null === $hotels) {
    		throw new NotFoundHttpException("Aucun hôtel n'est présent dans la base de données");
    	}
    	
    	
    	//affichage de la page demandée (liste des h�tels)
        return $this->render('MCDHHotelBundle:Hotel:index.html.twig', array(
        	'hotels' => $hotels,
        	'page' => $page
        ));
    }
    
    /**
     * Add a new hotel
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
    	
    	//instanciation de l'entité
    	$hotel = new Hotel();
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	
    	if($form->handleRequest($request)->isValid()){
    		
    		//récupréation de l'Entity Manager
    		$em = $this->getDoctrine()->getManager();
    		 
    		//persitance de l'entité
    		$em->persist($hotel);
    		$hotel->setAddedDate(new \Datetime());
    		 
    		//flush de l'entité
    		$em->flush();
    		
    		$request->getSession()->getFlashBag()->add('notice','Annonce bien enregistrée.');
    		
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => $hotel->getId())));
    		
    	}
    	
    	return $this->render('MCDHHotelBundle:Hotel:add.html.twig',array(
    			'form' => $form->createView(),
    	));
    }
    
    /**
     * Delete an hotel
     * 
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id, Request $request){
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($id);
    	
    	if($hotel == null){
    		throw $this->createNotFoundException("L'hôtel portant l'identifiant ".$id." n'existe pas. ");
    	}
    	
    	if($request->isMethod('POST')){
    		//affichage d'un message pour confirmer la suppression de l'hôtel
    		$request->getSession()->getFlashBag()->add('info', 'Hôtel supprimé.');
    		
    		return $this->redirect($this->generateUrl('mcdh_hotel_homepage'));
    	}
    	
    	//redirection vers la page d'accueil du bundle
    	return $this->render('MCDHHotelBundle:Hotel:delete.html.twig', array(
      		'hotel' => $hotel
   		));
    }
    
    /**
     * View an hotel
     * 
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id){
    	


    	$repository = $this->getDoctrine()
    	->getManager()
    	->getRepository('MCDHHotelBundle:Hotel');
    	 
    	$hotel = $repository->find($id);
    	
    	if($hotel == null){
    		throw new NotFoundHttpException("L'hôtel portant l'identifiant ".$id." ne peut être affiché car il n'existe pas. ");
    	}
    	
    	return $this->render('MCDHHotelBundle:Hotel:view.html.twig', array(
      		'hotel' => $hotel
   		));
    }
    
    /**
     * Edit an hotel
     * 
     * @param unknown $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request){
    	
    	$repository = $this->getDoctrine()
    	->getManager()
    	->getRepository('MCDHHotelBundle:Hotel');
    	
    	$hotel = $repository->find($id);
    	
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	 
    	if($form->handleRequest($request)->isValid()){
    	
    		//récupréation de l'Entity Manager
    		$em = $this->getDoctrine()->getManager();
    		 
    		//persitance de l'entité
    		$em->persist($hotel);
    		$hotel->setAddedDate(new \Datetime());
    		 
    		//flush de l'entité
    		$em->flush();
    	
    		$request->getSession()->getFlashBag()->add('notice','Annonce bien enregistrée.');
    	
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => $hotel->getId())));
    	
    	}
    	 
    	return $this->render('MCDHHotelBundle:Hotel:add.html.twig',array(
    			'form' => $form->createView(),
    	));
    	
    	
    	
    	
    	
    	
    	//si le formulaire est validé
    	if ($request->isMethod('POST')){
    		
    		//affichage d'un message pour confirmer l'enregistrement de l'hôtel
    		$request->getSession()->getFlashBag()->add('notice', 'H�tel modifi�.'); //Traduction ?
    		
    		//redirection vers la page de visualisation de l'h�tel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => 5)));
		}
		
		//affichage du formulaire de saisie d'un nouvel hôtel complété des informations de l'hôtel
    	return $this->render('MCDHHotelBundle:Hotel:edit.html.twig');
    }
}
