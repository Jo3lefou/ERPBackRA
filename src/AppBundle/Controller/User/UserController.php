<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/admin/{_locale}/users/", name="users")
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

        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        if($user){
            //var_dump($users);
            return $this->render('users/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | Users',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Find all the users'),
                'bodyClass' => 'nav-md',
                'users' => $users,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}