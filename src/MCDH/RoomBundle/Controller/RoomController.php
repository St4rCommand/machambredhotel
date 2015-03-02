<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class RoomController extends Controller{

	public function editAction($id){
	
	}
	
	public function addAction(){
		
	}
	
	public function deleteAction($id){
		
	}
	
	public function viewAction($id){
		
		$room = array(
			"num" => 203,
			"floor" => 2,
		);
		
		return $this->render('MCDHRoomBundle:Room:view.html.twig', array(
				'room' => $room
		));
		
	}
}
