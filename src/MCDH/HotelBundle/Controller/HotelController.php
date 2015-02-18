<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Main controller for HotelBundle
 * 
 * @author Romain
 *
 */
class DefaultController extends Controller
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
    	
    	//si la page demand�e n'existe pas
    	if ($page < 1) {
    		
    		//exception lev�e
    		throw new NotFoundHttpException('Page "'.$page.'" inexistante.'); // Traduction ?
    	}
    	
    	$listHotels = array(
    		array('id' => 1, 'name' => 'Carlton', 'city' => 'Lille', 'country' => 'France', 'date' => '17/02/2015')
    	);
    	
    	//affichage de la page demand�e (liste des h�tels)
        return $this->render('MCDHHotelBundle:Default:index.html.twig', array(
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
    	
    	//si le formulaire est valid�
    	if ($request->isMethod('POST')){
    		
    		//affichage d'un message pour confirmer l'enregistrement de l'h�tel
    		$request->getSession()->getFlashBag()->add('notice', 'H�tel bien enregistr�.'); //Traduction ?
    		
    		//redirection vers la page de visualisation de l'h�tel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => 5)));
    	}
    	
    	//affichage du formulaire de saisie d'un nouvel h�tel
    	return $this->render('MCDHHotelBundle:Default:add.html.twig');
    }
    
    /**
     * Delete an hotel
     * 
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id, Request $request){
    	
    	//affichage d'un message pour confirmer la suppression de l'h�tel
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
    	
    	return $this->render('MCDHHotelBundle:Default:view.html.twig', array(
      		'id' => $id
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
    	
    	//si le formulaire est valid�
    	if ($request->isMethod('POST')){
    		
    		//affichage d'un message pour confirmer l'enregistrement de l'h�tel
    		$request->getSession()->getFlashBag()->add('notice', 'H�tel modifi�.'); //Traduction ?
    		
    		//redirection vers la page de visualisation de l'h�tel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('id' => 5)));
		}
		
		//affichage du formulaire de saisie d'un nouvel h�tel compl�t� des informations de l'h�tel
    	return $this->render('MCDHHotelBundle:Default:edit.html.twig');
    }
}
