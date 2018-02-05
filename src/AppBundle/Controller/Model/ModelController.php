<?php

namespace AppBundle\Controller\Model;

use AppBundle\Entity\RarModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ModelController extends Controller
{
    /**
     * @Route("/admin/{_locale}/models/{display}/{number}/", name="models")
     *
     * Security("has_role('ROLE_ADMIN')")
     *
     */
    public function indexAction($display= 'view', $number = '25', Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarModel::class);
        //$models = $repository->findAll();
        $searchTerm = "";

        if($display == 'view'){
            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM AppBundle:RarModel a ORDER BY a.name";
            $query = $em->createQuery($dql);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate( $query, $request->query->getInt('page', 1), $number );
        }elseif($display == 'search'){
            $request = new Request($_GET);
            $term = $request->query->get('term');
            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM AppBundle:RarModel a WHERE a.name LIKE '%".addcslashes($term, '%_')."%' OR a.sku LIKE '%".addcslashes($term, '%_')."%'";
            $query = $em->createQuery($dql);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate( $query, $request->query->getInt('page', 1), $number );
            $searchTerm = $term;
        }else{
            return $this->redirect('/admin/'.$locale.'/models/view/'.$number);
        }


        if($user){
            //var_dump($users);
            return $this->render('models/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | models',
                'h1title' => 'Welcome User',
                'p1h2' => $this->get('translator')->trans('Find all models'),
                'bodyClass' => 'nav-md',
                //'models' => $models,
                'user' => $user,
                'pagination' => $pagination,
                'nbitem' => $number,
                'searchterm' => $searchTerm
            ));

        }else{
            return $this->redirect('login');
        }
    }
}