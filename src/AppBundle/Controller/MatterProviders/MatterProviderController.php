<?php

namespace AppBundle\Controller\MatterProviders;

use AppBundle\Entity\RarMatterProvider;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MatterProviderController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matterproviders/", name="matterproviders")
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

        $repository = $this->getDoctrine()->getRepository(RarMatterProvider::class);
        $matterproviders = $repository->findAll();

        if($user){
            //var_dump($users);
            return $this->render('matterproviders/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | Providers',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Find all matter providers'),
                'bodyClass' => 'nav-md',
                'matterproviders' => $matterproviders,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}