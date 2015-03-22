<?php

namespace MCDH\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MCDH\HotelBundle\Entity\Hotel;
use MCDH\HotelBundle\Form\HotelType;
use MCDH\HotelBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * Contrôleur pour la gestion des hôtels
 *
 */
class HotelController extends Controller
{
	/**
	 * Page d'accueil de l'onglet "Hotel"
	 * Affichage de la liste des hôtels proposés
	 * 
	 * @param int $page
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction($page){
    	
    	//si la page demandée n'existe pas, exception levée
    	if ($page < 1) {
    		throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    	}
    	
    	//définition du nombre d'hôtels à afficher par page
    	$nbPerPage = 10;

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
    		throw new NotFoundHttpException("Page ".$page." inexistante.");
    	}
    	
    	//affichage de la liste des hôtels
        return $this->render('MCDHHotelBundle:Hotel:index.html.twig', array(
        	'hotels' => $hotels,
        	'nbPages' => $nbPages,
        	'page' => $page
        ));
    }
    
    /**
     * Ajouter un nouvel hôtel
     * Seul les utilisateurs ayant le role ROLE_HOTELKEEPER et l'administrateur peuvent executer cette fonction
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_HOTELKEEPER')")
     */
    public function addAction(Request $request){
    	
    	//instanciation d'un hôtel
    	$hotel = new Hotel();
    	$hotel->setAddedDate(new \Datetime());
    	
    	//création du formulaire
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	
    	//si le formulaire a été validé
    	if($form->handleRequest($request)->isValid()){
    		
    		$hotel->setHotelKeeper($this->getUser());
    		
    		//récupréation de l'Entity Manager
    		$em = $this->getDoctrine()->getManager();
    		 
    		//persitance de l'entité
    		$em->persist($hotel);
    		 
    		//flush de l'entité
    		$em->flush();
    		
    		$request->getSession()->getFlashBag()->add('notice','Annonce bien enregistrée.');
    		
    		//redirection vers l'hôtel ajouté
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('idHotel' => $hotel->getId())));
    		
    	}
    	
    	//sinon affichage du formulaire
    	return $this->render('MCDHHotelBundle:Hotel:add.html.twig',array(
    			'form' => $form->createView(),
    	));
    }
    
    /**
     * Voir les détails d'un hôtel
     * Les détails de l'hôtel ainsi que les éventuelles chambres sont affichées
     * Tous les utilisateurs peuvent accéder à cette fonction
     * 
     * @param int $idHotel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($idHotel){
    	
    	//récupréation de l'Entity Manager
    	$em = $this->getDoctrine()->getManager();
    	
    	//récupération dans la base de l'hôtel à afficher
    	$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//affichage d'une erreur si l'hôtel n'existe pas
    	if($hotel === null){
    		throw new NotFoundHttpException("Aucun hôtel ne porte l'identifiant ".$idHotel.".");
    	}
    	
    	//sélection des chambres de cet hôtel
    	$rooms = $em->getRepository('MCDHHotelBundle:Room')->findBy(array('hotel' => $hotel));
    	
    	//affichage des caractéristiques de l'hôtel
    	return $this->render('MCDHHotelBundle:Hotel:view.html.twig', array(
      		'hotel' => $hotel,
    		'rooms' => $rooms
   		));
    }
    
    /**
     * Editer un hôtel
     * Le propriétaire de l'hôtel et l'administrateur peuvent executer cette fonction
     * 
     * @param int $idHotel
     * @param Request $request
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedException
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_HOTELKEEPER')")
     */
    public function editAction($idHotel, Request $request){

    	//récupréation de l'Entity Manager
    	$em = $this->getDoctrine()->getManager();
    	
    	//récupération dans la base de données de l'hôtel à éditer
    	$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//création du formulaire
    	$form = $this->get('form.factory')->create(new HotelType(), $hotel);
    	
    	//affichage d'une erreur si l'hôtel n'existe pas
    	if($hotel === null){
    		throw new NotFoundHttpException("Aucun hôtel ne porte l'identifiant ".$idHotel.".");
    	}

    	//vérification que le propriétaire courant est soit le propriétaire, soit l'administrateur
    	$hotelkeeper = $hotel->getHotelKeeper();
    	$user = $this->getUser();
    	if($user != $hotelkeeper and !$this->get('security.context')->isGranted('ROLE_ADMIN')){
    		throw new AccessDeniedException("Vous n'avez pas les droits suffisants pour accéder à cet hôtel.");
    	}
    	 
    	//si le formulaire a été validé
    	if($form->handleRequest($request)->isValid()){
    		 
    		//flush de l'entité
    		$em->flush();
    	
    		//affichage d'un message pour confirmer la prise en compte des modifications de l'hôtel
    		$request->getSession()->getFlashBag()->add('notice','Les modifications ont bien été prise en compte.');
    	
    		//redirection vers la page affichant l'hôtel
    		return $this->redirect($this->generateUrl('mcdh_hotel_view', array('idHotel' => $hotel->getId())));
    	
    	}
    	//sinon affichage du formulaire d'édition
    	return $this->render('MCDHHotelBundle:Hotel:edit.html.twig',array(
    			'form' => $form->createView(),
    			'hotel' => $hotel
    	));
    }
    
    /**
     * Supprimer un hôtel
     * Pour des raisons de sécurité, seul les administrateur peuvent supprimer des hôtels
     *  
     * @param int $idHotel
	 * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($idHotel, Request $request){
    	
    	//récupération de l'Entity Manager
    	$em = $this->getDoctrine()->getManager();
    	
    	//récupération dans la base de données de l'hôtel à supprimer
    	$hotel = $em->getRepository('MCDHHotelBundle:Hotel')->find($idHotel);
    	
    	//affichage d'une erreur si l'hôtel n'existe pas
    	if($hotel === null){
    		throw new NotFoundHttpException("Aucun hôtel ne porte l'identifiant ".$idHotel.".");
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

    	//sinon affichage du formulaire de validation
    	return $this->render('MCDHHotelBundle:Hotel:delete.html.twig',array(
    		'hotel'=>$hotel,
    		'form'=>$form->createView()
    	));
    }
}
