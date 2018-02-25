<?php

namespace AppBundle\Controller\Orders;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarPayment;
use AppBundle\Form\RarOrderType;
use AppBundle\Form\RarCustomerType;

// Image de la cliente a uplaoder
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
// Fin image cliente...

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class ViewOrderController extends Controller
{

    /**
     * @Route("/{_locale}/orders/single/{id}", name="vieworder")
     */
    public function newAction($id)
    {

    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $role = $this->getUser()->getRole();

        if($user){
        	$em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('AppBundle:RarOrder')->find($id);
            $modelsOrdered = $order->getModelsOrdered();

            $customer =  $order->getCustomer();
            $customerAllow = $order->getUser()->getCustomerAllow();
            $shop = $order->getShop();
            $shopStatus = $shop->getIsDirectCustomer();
            $vatStatus = $shop->getIsVat();
            $amountVAT = $shop->getAmountVat();
            $shopID = $shop->getId();
            $status = $order->getState();
            $modelsOrdered = $order->getmodelsOrdered();

            $query = $this->getDoctrine()->getRepository('AppBundle:RarPayment');
            $queryTotalPayment = $query->createQueryBuilder('p')
            ->select("sum(p.amount)")
            ->Where('p.order = :order')
            ->setParameter('order', $order)
            ->getQuery();

            $paiment = $queryTotalPayment->getSingleScalarResult();


            $detailsOrder = array();
            $totalPrice = '';
            $totalVAT = '';
            $totalwVAT = '';
            $totalwoVAT = '';

            foreach ($modelsOrdered as $key => $modelOrdered) {
                // = [Montant HT]
            	$totalPrice = $totalPrice + $modelOrdered->getPrixSoldHT();
            	if($vatStatus == 1){
            		$totalwVAT = $totalVAT+$totalPrice;
                    $totalwoVAT = $totalPrice/(1+($amountVAT/100));
                    $totalVAT = $totalwoVAT*($amountVAT/ 100);
            	}
            }
            $detailsOrder = array(
            	'totalPrice' => $totalPrice,
            	'totalVAT' => $totalVAT,
                'totalHT' => $totalwoVAT,
            );





    		return $this->render('orders/order/vieworder.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'title' => ' | '.$this->get('translator')->trans('View order'),
                    'h1title' => 'Votre profile',
                    'h1' => $this->get('translator')->trans('Order'),
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'customer' => $customer,
                    'shop' => $shop,
                    'order' => $order,
                    'detailsOrder' => $detailsOrder,
                    'payment' => $paiment,
                    'modelsOrdered' => $modelsOrdered,
                )
            );
		}else{
            return $this->redirect('login');
        }
    }
}