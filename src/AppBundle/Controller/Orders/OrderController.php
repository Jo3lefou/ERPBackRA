<?php

namespace AppBundle\Controller\Orders;

use AppBundle\Entity\RarOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderController extends Controller
{
    /**
     *
     * @Route("/{_locale}/orders/view/{type}/{status}", name="orders")
     *
     */
    public function indexAction($type = 'all', $status = 'all', UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarOrder::class);

        // On affiche que les commandes lié aux boutiques relié a notre utilisateur
        $shoplist = $this->getUser()->getShops();
        $numItems = count($shoplist);
        $i = 0;
        $condition = '';

        if($type == 'all'){

        }elseif($type == 'eshop'){
            $condition .= ' d.isEshop = 1 AND ';
        }elseif($type == 'showroom'){
            $condition .= ' d.isDirectCustomer = 1 AND d.isEshop = 0 AND ';
        }elseif($type == 'shop'){
            $condition .= ' d.isDirectCustomer = 0 AND ';
        }elseif($type == 'stock'){
            $condition .= ' c.type = 1 AND ';
        }elseif($type == 'proto'){
            $condition .= ' c.type = 2 AND ';
        }

        if($status == 'all'){
            $condition .= ' c.state IN (1,2,3,4,5) AND (';
        }elseif($status == 'draft'){
            $condition .= ' c.state = 0 AND (';
        }elseif($status == 'finished'){
            $condition .= ' c.state IN (6,7,8) AND c.dateShipped <= :date AND (';
        }elseif($status == 'history'){
            $condition .= ' c.state IN (6,7,8) AND c.dateShipped >= :date AND (';
        }

        foreach ($shoplist as $key => $shop) {
            $condition .= 'c.shop = '.$shop->getId();
            if(++$i === $numItems) {
                $condition .= ')';
            }else{
                $condition .= ' OR ';
            }
        }

        $query = $repository->createQueryBuilder('c')
            ->leftJoin('c.shop', 'd')
            ->where($condition)
            ->orderBy('c.dateOrder', 'DESC')
            ->getQuery();
        if($status == 'history'){
            $query->setParameter('date', new \DateTime('-2 month'));
        }elseif($status == 'finished'){
            $query->setParameter('date', new \DateTime('-2 month'));
        }

        $orders = $query->getResult();
        
        
        //print_r($orders);

        if($user){
            return $this->render('orders/list.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new order'),
                    'p1h2' => $this->get('translator')->trans('Orders list'),
                    'p1h3' => $this->get('translator')->trans('Create here your new order'),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('Order'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'orders' => $orders,
                    'status' => $status,
                    'type' => $type
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}
