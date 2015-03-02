<?php

namespace MCDH\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MCDHRoomBundle:Default:index.html.twig', array('name' => $name));
    }
}
