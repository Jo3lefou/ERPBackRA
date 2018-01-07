<?php

namespace AppBundle\Controller\Orders;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarSize;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\RarModelOrdered;
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


class CreateOrderController extends Controller
{

    /**
     * @Route("/{_locale}/orders/create/", name="createorder")
     */
    public function newAction(Request $request, FileUpload $file_upload, MessageGenerator $messageGenerator)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $role = $this->getUser()->getRole();
        $customerAllow = $this->getUser()->getCustomerAllow();
        $name = $firstName.' '.$lastName;

        switch($role){
            case 'ROLE_ADMIN':
                $adminRights = true;
            break;
            case 'ROLE_USER':
                $adminRights = false;
            break;
            case 'ROLE_PROVIDER':
                $adminRights = false;
            break;
            case 'ROLE_SALE_MANAGER':
                $adminRights = true;
            break;
            case 'ROLE_SALE':
                $adminRights = false;
            break;
            case 'ROLE_ACCOUNTING_MANAGER':
                $adminRights = true;
            break;
            case 'ROLE_PRODUCTION_MANAGER':
                $adminRights = true;
            break;
        }
        if($user){
            $newOrder = new RarOrder();
            // New model
            $size = new RarModelOrdered();
            $newOrder->setUser($user);
            //$options = array('order'=>$newOrder, 'user'=>$user);

            // Creation du Form basé sur le form UserType
            if($customerAllow == 1){
                $customer = new RarCustomer();
                $form = $this->createForm(RarOrderType::class, $newOrder, ['attr' => ['adminRights' => $adminRights, 'type' => 'create'] ])
                ->add('shop', entityType::class,
                   array(
                         'label'=>'Select the purchaser',
                         'class'=>'AppBundle:RarShop',
                         'choice_label' => 'name',
                         'required' => true,
                         'choices' => $user->getShops(),
                        )
                )
                ->add('customer', RarCustomerType::class, [
                        'required' => false,
                    ]);
            }else{
                $form = $this->createForm(RarOrderType::class, $newOrder )
                ->add('shop', entityType::class,
                   array(
                         'label'=>'Select the purchaser',
                         'class'=>'AppBundle:RarShop',
                         'choice_label' => 'name',
                         'required' => true,
                         'choices' => $user->getShops(),
                        )
                )
                ->add('customerName', TextType::class,[
                    'label' => 'Customer name'
                ]);
            }
            

            // ** On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // ** On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // ** On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // ** On récupère les données du formulaire
                $newOrder = $form->getData();
                $newOrder->setUser($user);

                if($customerAllow == 1){
                    if( $request->request->get('idCustomer') ){
                        // ** if customer is already existing 
                        $idCustomer = $request->request->get('idCustomer');
                        $em = $this->getDoctrine()->getManager();
                        $customer = $em->getRepository('AppBundle:RarCustomer')->find($idCustomer);
                    }else{
                        // ** Create new customer
                        $customer = $newOrder->getCustomer();
                        $customer->setDateModification(date_create(date('Y/m/d H:i:s')));
                        $customer->setDateCreation(date_create(date('Y/m/d H:i:s')));
                    }
                }

                // ** Shop status
                $shop = $newOrder->getShop();
                $shopStatus = $shop->getIsDirectCustomer();
                $vatStatus = $shop->getIsVat();
                $contractStatus = $shop->getIsContract();
                $contractAmount = $shop->getAmountContract();
                $amountVAT = $shop->getAmountVat();
                $shopID = $shop->getId();
                // ** Order status
                $status = $newOrder->getState();
                
                // ** Set Date Order
                if($newOrder->getState() == '1'){
                    // ** Get Year
                    $monthNum = date('m');
                    if( intval($monthNum) >=9 ){
                        $yearnum = date('y');
                        $year = intval($yearnum)+1;
                    }else{
                        $year = date('y');
                    }

                    // ** Set Date Creation
                    $time = date_create(date('Y/m/d H:i:s'));
                    $newOrder->setDateOrder($time);

                    // ** Set Id Compta
                    $repositoryOrder = $this->getDoctrine()
                        ->getRepository(RarOrder::class);
                    $queryMaxOrder = $repositoryOrder->createQueryBuilder('c')
                        ->select("MAX(c.idCompta) as cid")
                        ->where('c.shop = :shop')
                        ->andwhere('c.year = :year')
                        ->setParameter('shop', $shop)
                        ->setParameter('year', $year);
                    $maxID = $queryMaxOrder->getQuery()->getResult();
                    $idCompta = $maxID[0]['cid']+1;
                    $newOrder->setIdCompta($idCompta);
                    $newOrder->setYear($year);
                }
                // ** Set Customer
                if($customerAllow == 1){
                    $newOrder->setCustomer($customer);
                }
                // ** Save Order
                //----------------------------------
                // Notification Commande Classique
                $newOrder->setType(0);
                $em->persist($newOrder);
                $em->flush();



                // ** Recup Order ID
                $idOrder = $newOrder->getId();
                //-------------------------------
                // ** Update OrderID on ModelOrdered
                //----------------------------------
                foreach ( $newOrder->getModelsOrdered() as $model ){
                    // ** On récupère le prix du model
                    $maxWeek = $model->getModel()->getMaxShipWeek();
                    $minWeek = $model->getModel()->getMinShipWeek();
                    // ** On récupère l'atelier du model par défaut
                    $workroom = $model->getModel()->getWorkroom();

                    // ** On récupère les prix variables de la taille ** //
                    $repositoryOrder = $this->getDoctrine()
                        ->getRepository(RarSize::class);
                    $queryPricesSize = $repositoryOrder->createQueryBuilder('s')
                        ->select("s.supPriceHT as supHt, s.supPriceShop as supShop")
                        ->where('s.nameSize = :nameSize')
                        ->andwhere('s.model = :model')
                        ->setParameter('nameSize', $model->getSize() )
                        ->setParameter('model', $model->getModel() );
                    $pricesSize = $queryPricesSize->getQuery()->getResult();
                    // ** Si la boutique achete RA au prix Retails (ex. Showroom)
                    if($shopStatus == 1){
                        if($vatStatus == 1){
                            $priceSold = $model->getModel()->getPrixHT();
                            $tvaAmount = ($priceSold+$pricesSize[0]['supHt'])*$amountVAT/100;
                            $price = $tvaAmount+$priceSold;
                        }else{
                            $price = $model->getModel()->getPrixHT()+$pricesSize[0]['supHt'];
                        }
                    // ** Si la boutique achete RA a un prix contractualisé
                    }elseif($contractStatus ==1){
                        if($vatStatus == 1){
                            $priceSold = $model->getModel()->getPrixHT();
                            $tvaAmount = ($priceSold+$pricesSize[0]['supHt'])*$amountVAT/100;
                            $price = ($tvaAmount+$priceSold)*($contractAmount/100);
                        }else{
                            $price = ($model->getModel()->getPrixHT()+$pricesSize[0]['supShop'])*($contractAmount/100);
                        }
                    // ** Si la boutique achete RA au prix Wholesale (ex. Revendeur)
                    }else{
                        if($vatStatus == 1){
                            $priceSold = $model->getModel()->getPrixShop();
                            $tvaAmount = ($priceSold+$pricesSize[0]['supShop'])*$amountVAT/100;
                            $price = $tvaAmount+$priceSold;
                        }else{
                            $price = $model->getModel()->getPrixShop()+$pricesSize[0]['supShop'];
                        }
                    }

                    // *******************
                    // Penser au boutique sous contrat... 
                    // *******************

                    if( $status == 0 ){
                    // ** If Draft :
                        // Do nothing about Shipping Date
                    }else if( $status == 1 ){
                    // ** if Published :
                        $maxDateShip = date_create(date("Y/m/d H:i:s", strtotime("+".$maxWeek." week")));
                        $minDateShip = date_create(date("Y/m/d H:i:s", strtotime("+".$minWeek." week")));
                        $model->setMinProdShip($minDateShip);
                        $model->setMaxProdShip($maxDateShip);
                    }
                    $model->setDateCreation($time);
                    $model->setWorkroom($workroom);
                    $model->setStatus(0);
                    $model->setPrixSoldHT($price);
                    $model->setOrder($newOrder);
                    $em->flush();
                }
                //-------------------------------

                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('orders');
            }

            return $this->render('orders/order/order.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new order'),
                    'p1h2' => $this->get('translator')->trans('Orders'),
                    'p1h3' => $this->get('translator')->trans('Create here your new order'),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('Order'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'form' => $form->createView()
                )
            );

        }else{
            return $this->redirect('login');
        }
    }
}