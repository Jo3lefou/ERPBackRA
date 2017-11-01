<?php

namespace AppBundle\Controller;

//use AppBundle\Entity\RarOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class LogoutController extends Controller
{
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    	
    }
    
}
