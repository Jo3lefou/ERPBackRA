<?php

namespace AppBundle\Controller\Matters;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\RarMatter;
use AppBundle\Entity\RarMatterProvider;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MatterController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matters/", name="matters")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarMatter::class);
        $matter = $repository->findAll();

        if($user){
            //var_dump($matter);
            return $this->render('matters/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | Matter Providers',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Find all matters'),
                'bodyClass' => 'nav-md',
                'matters' => $matter,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}