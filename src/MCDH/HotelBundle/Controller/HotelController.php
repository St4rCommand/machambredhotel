<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MCDH\HotelBundle\Entity\Hotel;

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
    	
    	$listHotels = array(
    		array('id' => 1, 'name' => 'Carlton', 'city' => 'Lille', 'country' => 'France', 'date' => '17022015')
    	);
    	
    	//affichage de la page demandée (liste des h�tels)
        return $this->render('MCDHHotelBundle:Hotel:index.html.twig', array(
        	'listHotels' => $listHotels
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
    	$hotel->setName("Carlton");
    	$hotel->setAddress("Place centrale");
    	$hotel->setPostCode("59000");
    	$hotel->setCity("Lille");
    	$hotel->setCountry("France");
    	$hotel->setAddedDate(new \DateTime());
    	
    	//récupréation de l'Entity Manager
    	$em = $this->getDoctrine()->getManager();
    	
    	//persitance de l'entité
    	$em->persist($hotel);
    	
    	//flush de l'entité
    	$em->flush();

    	
    	//si le formulaire est validé
    	if ($request->isMethod('POST')){
    		
    		//affichage d'un message pour confirmer l'enregistrement de l'hôtel
    		$request->getSession()->getFlashBag()->add('notice', 'Hôtel bien enregistré.'); //Traduction ?
    		
    		//redirection vers la page de visualisation de l'hôtel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => 5)));
    	}
    	
    	//affichage du formulaire de saisie d'un nouvel hôtel
    	return $this->render('MCDHHotelBundle:Hotel:add.html.twig');
    }
    
    /**
     * Delete an hotel
     * 
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id, Request $request){
    	
    	//affichage d'un message pour confirmer la suppression de l'hôtel
    	$request->getSession()->getFlashBag()->add('notice', 'H�tel supprim�.'); //Traduction ?
    	
    	//redirection vers la page d'accueil du bundle
    	return $this->redirect($this->generateUrl('mcdh_hotel_homepage'));
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
