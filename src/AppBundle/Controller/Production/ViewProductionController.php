<?php

namespace AppBundle\Controller\Production;

use AppBundle\Entity\RarModelOrdered;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ViewProductionController extends Controller
{
    /**
     *
     * @Route("/{_locale}/production/single/{id}", name="viewproduction")
     *
     */
    public function indexAction($id, UserInterface $user)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

        	$repository = $this->getDoctrine()->getRepository(RarModelOrdered::class);
        	$modelOrdered = $repository->findOneBy(['id' => $id]);

            $order =  $modelOrdered->getOrder();
            $model =  $modelOrdered->getModel();
            $logs = $modelOrdered->getOrderLogs();
            $customer = $order->getCustomer();
            $shop = $order->getShop();
            $userOrder = $order->getUser();
            if(empty($customer)){
            	$customer['name'] = $order->getCustomerName();
            }

        	return $this->render('productions/production/viewproduction.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'title' => ' | '.$this->get('translator')->trans('View production'),
                    'h1title' => 'Votre profile',
                    'h1' => $this->get('translator')->trans('Order'),
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'customer' => $customer,
                    'shop' => $shop,
                    'order' => $order,
                    'userOrder' => $userOrder,
                    'modelOrdered' => $modelOrdered,
                    'logs' => $logs,
                    'model' => $model,
                )
            );
        

		}else{
            return $this->redirect('login');
        }
    }
}