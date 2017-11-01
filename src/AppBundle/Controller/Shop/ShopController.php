<?php

namespace AppBundle\Controller\Shop;

use AppBundle\Entity\RarShop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShopController extends Controller
{
    /**
     * @Route("/admin/{_locale}/shops/", name="shops")
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

        $repository = $this->getDoctrine()->getRepository(RarShop::class);
        $shops = $repository->findAll();

        if($user){
            //var_dump($users);
            return $this->render('shops/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | orders',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Find all shops'),
                'bodyClass' => 'nav-md',
                'shops' => $shops,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}