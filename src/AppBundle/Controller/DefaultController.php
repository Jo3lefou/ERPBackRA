<?php

namespace AppBundle\Controller;

//use AppBundle\Entity\RarOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(UserInterface $user)
    {
        
        if($user){
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $locale = $this->getUser()->getLocale();
            return $this->redirect('/'.$locale.'/home/');

        }else{
            return $this->redirect('/login/');
        }

    }

}
