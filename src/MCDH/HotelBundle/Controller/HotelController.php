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
    public function indexAction($page){
    	
    	//si la page demandée n'existe pas
    	if ($page < 1) {
    	
    		//exception levée
    		throw new NotFoundHttpException('Page "'.$page.'" inexistante.'); // Traduction ?
    	}
    	
    	$nbPerPage = 4;

    	//récupération des hotels de la base de données
    	$hotels = $this
    		->getDoctrine()
    		->getManager()
    		->getRepository('MCDHHotelBundle:Hotel')
    		->getHotels($page,$nbPerPage);
    	
    	//exception si aucun hotel trouvé
    	if (null === $hotels) {
    		throw new NotFoundHttpException("Aucun hôtel n'est présent dans la base de données");
    	}
    	
    	//calcul du nombre de pages
    	$nbPages = ceil(count($hotels)/$nbPerPage);
    	
    	//si la page demandée est supérieur au nombre de page
    	if ($page > $nbPages) {
    		throw $this->createNotFoundException("Page ".$page." inexistante.");
    	}
    	
    	//affichage de la liste des hôtels
        return $this->render('MCDHHotelBundle:Hotel:index.html.twig', array(
        	'hotels' => $hotels,
        	'nbPages' => $nbPages,
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
    	
    	//création du formulaire
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	
    	//si le formulaire d'ajout a été validé
    	if($form->handleRequest($request)->isValid()){
    		
    		//récupréation de l'Entity Manager
    		$em = $this->getDoctrine()->getManager();
    		 
    		//persitance de l'entité
    		$em->persist($hotel);
    		$hotel->setAddedDate(new \Datetime());
    		 
    		//flush de l'entité
    		$em->flush();
    		
    		$request->getSession()->getFlashBag()->add('notice','Annonce bien enregistrée.');
    		
    		//redirection vers l'hôtel ajouté
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('idHotel' => $hotel->getId())));
    		
    	}
    	
    	//affichage du formulaire
    	return $this->render('MCDHHotelBundle:Hotel:add.html.twig',array(
    			'form' => $form->createView(),
    	));
    }
    
    /**
     * Delete an hotel
     * 
     * @param unknown $idHotel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($idHotel, Request $request){
    	
    	//récupération de l'Entity Manager
    	$em = $this->getDoctrine()->getManager();
    	
    	//récupération dans la base de données de l'hôtel à supprimer
    	$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//affichage d'une erreur si l'hôtel n'existe pas
    	if($hotel == null){
    		throw $this->createNotFoundException("L'hôtel portant l'identifiant ".$idHotel." n'existe pas. ");
    	}
    	
    	//création d'un formulaire de validation
    	$form = $this->createFormBuilder()
    		->add('delete',	'submit')
    		->getForm();
    	
    	//si le formulaire a été validé
    	if($form->handleRequest($request)->isValid()){
    		//suppression de l'hôtel
    		$em->remove($hotel);
    		$em->flush();
    		
    		//affichage d'un message pour confirmer la suppression de l'hôtel
    		$request->getSession()->getFlashBag()->add('info', 'Hôtel supprimé.');
    		 
    		//retour à la page d'accueil
    		return $this->redirect($this->generateUrl('mcdh_hotel_homepage'));
    	}

    	return $this->render('MCDHHotelBundle:Hotel:delete.html.twig',array(
    		'hotel'=>$hotel,
    		'form'=>$form->createView()
    	));
    }
    
    /**
     * View an hotel
     * 
     * @param unknown $idHotel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($idHotel){
    	
    	//récupération dans la base de l'hôtel à afficher
    	$hotel = $this->getDoctrine()->getManager()->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//affichage d'une erreur si l'hôtel n'existe pas
    	if($hotel == null){
    		throw new NotFoundHttpException("L'hôtel portant l'identifiant ".$idHotel." ne peut être affiché car il n'existe pas. ");
    	}
    	
    	//affichage des caractéristiques de l'hôtel
    	return $this->render('MCDHHotelBundle:Hotel:view.html.twig', array(
      		'hotel' => $hotel
   		));
    }
    
    /**
     * Edit an hotel
     * 
     * @param unknown $idHotel
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($idHotel, Request $request){
    	
    	//récupération dans la base de données de l'hôtel à éditer
    	$hotel = $this->getDoctrine()->getManager()->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//création du formulaire
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	 
    	//si le formulaire a été validé
    	if($form->handleRequest($request)->isValid()){
    	
    		//récupréation de l'Entity Manager
    		$em = $this->getDoctrine()->getManager();
    		 
    		//flush de l'entité
    		$em->flush();
    	
    		//affichage d'un message pour confirmer la prise en compte des modification de l'hôtel
    		$request->getSession()->getFlashBag()->add('notice','Les modifications ont bien été prise en compte.');
    	
    		//redirection vers la page affichant l'hôtel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('idHotel' => $hotel->getId())));
    	
    	}
    	
    	return $this->render('MCDHHotelBundle:Hotel:edit.html.twig',array(
    			'form' => $form->createView(),
    			'hotel' => $hotel
    	));
    }
}
