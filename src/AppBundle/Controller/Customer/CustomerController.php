<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\RarCustomer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;

class CustomerController extends Controller
{
    /**
     *
     * @Route("/{_locale}/customers/{display}/{number}/", name="customers")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_PRODUCTION_MANAGER') or has_role('ROLE_SALE_MANAGER') or has_role('ROLE_SALE') or has_role('ROLE_ACCOUNTING_MANAGER')")
     */
    public function indexAction($display= 'view', $number = '25', UserInterface $user, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarCustomer::class);
        //$customers = $repository->findAll();
        $searchTerm = "";
        if($display == 'view'){
            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM AppBundle:RarCustomer a";
            $query = $em->createQuery($dql);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate( $query, $request->query->getInt('page', 1), $number );

        }elseif($display == 'search'){
            $request = new Request($_GET);
            $term = $request->query->get('term');
            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM AppBundle:RarCustomer a WHERE a.lastName LIKE '%".addcslashes($term, '%_')."%' OR a.firstName LIKE '%".addcslashes($term, '%_')."%'";
            $query = $em->createQuery($dql);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate( $query, $request->query->getInt('page', 1), $number );
            $searchTerm = $term;
            
        }else{
            return $this->redirect('/admin/'.$locale.'/customers/view/'.$number);
        }

        if($user){
            return $this->render('customers/list.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new customer'),
                    'p1h2' => $this->get('translator')->trans('Customers list'),
                    'p1h3' => $this->get('translator')->trans('Create here your new customer'),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('Order'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    //'customers' => $customers,
                    'pagination' => $pagination,
                    'nbitem' => $number,
                    'searchterm' => $searchTerm
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}
