<?php

namespace AppBundle\Controller\Workroom;

use AppBundle\Entity\RarWorkroom;

use AppBundle\Entity\RarShop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WorkroomController extends Controller
{
    /**
     * @Route("/admin/{_locale}/workrooms/", name="workrooms")
     *
     * Security("has_role('ROLE_ADMIN')")
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarWorkroom::class);
        $workrooms = $repository->findAll();

        if($user){
            //var_dump($users);
            return $this->render('workrooms/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | Workrooms',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Find all workrooms'),
                'bodyClass' => 'nav-md',
                'workrooms' => $workrooms,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}