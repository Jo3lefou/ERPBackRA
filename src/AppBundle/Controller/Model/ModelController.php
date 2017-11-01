<?php

namespace AppBundle\Controller\Model;

use AppBundle\Entity\RarModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ModelController extends Controller
{
    /**
     * @Route("/admin/{_locale}/models/", name="models")
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

        $repository = $this->getDoctrine()->getRepository(RarModel::class);
        $models = $repository->findAll();

        if($user){
            //var_dump($users);
            return $this->render('models/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | models',
                'h1title' => 'Welcome User',
                'p1h2' => $this->get('translator')->trans('Find all models'),
                'bodyClass' => 'nav-md',
                'models' => $models,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}