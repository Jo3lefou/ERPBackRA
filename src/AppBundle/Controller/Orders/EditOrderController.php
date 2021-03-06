<?php

namespace AppBundle\Controller\Orders;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarOrderNotes;
use AppBundle\Entity\RarOrderLog;
use AppBundle\Entity\RarSize;
use AppBundle\Entity\RarModel;

use AppBundle\Form\RarEditOrderType;
use AppBundle\Form\RarCustomerType;
use AppBundle\Form\Bloc\OrderNoteType;



// Image de la cliente a uplaoder
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
// Fin image cliente...

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class EditOrderController extends Controller
{

    /**
     * @Route("/{_locale}/orders/edit/{id}", name="editorder")
     */
    public function editAction($id, Request $request, MessageGenerator $messageGenerator)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $role = $this->getUser()->getRole();
        
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

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RarOrder')->find($id);
            if( $entity->getType() == 0 ){
                $form = $this->createForm(RarEditOrderType::class, $entity, 
                    ['attr' => [
                        'adminRights' => $adminRights, 
                        'type' => 'edit',
                        'classic' => true,
                        ] 
                    ])
                    ->add('note', TextareaType::class, array('mapped' => false, 'required' => false))
                ;
                $h1 = 'Edit the order';
            }else{
                $form = $this->createForm(RarEditOrderType::class, $entity, 
                    ['attr' => [
                        'adminRights' => $adminRights, 
                        'type' => 'edit',
                        'classic' => false,
                        ] 
                    ])
                    ->add('note', TextareaType::class, array('mapped' => false, 'required' => false))
                ;
                if( $entity->getType() == 1 ){
                    $h1 = 'Edit the prototype order';
                }else{
                    $h1 = 'Edit the stock order';
                }
            }
            $customer =  $entity->getCustomer();
            $customerAllow = $entity->getUser()->getCustomerAllow();
            $shop = $entity->getShop();
            $shopStatus = $shop->getIsDirectCustomer();
            $vatStatus = $shop->getIsVat();
            $contractStatus = $shop->getIsContract();
            $contractAmount = $shop->getAmountContract();
            $amountVAT = $shop->getAmountVat();
            $shopID = $shop->getId();
            $status = $entity->getState();
            $notes = $entity->getNotes();


            if( $contractStatus == '1'){
                $modellist = $em->getRepository('AppBundle:RarModel')->findBy( array('isActive' => '1', 'isContract' => '1'), array('name' => 'ASC') );
            }elseif( $shopStatus == '1'){
                $modellist = $em->getRepository('AppBundle:RarModel')->findBy( array('isActive' => '1'), array('name' => 'ASC') );
            }else{
                $modellist = $em->getRepository('AppBundle:RarModel')->findBy( array('isActive' => '1', 'isShop' => '1'), array('name' => 'ASC') );
            }

            $message = "";
            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);
            if ( $form->isSubmitted() ) {

                $entity = $form->getData();

                // Set Date Creation
                $time = date_create(date('Y/m/d H:i:s'));
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();



                ///////////////////////////
                //        ATTENTION
                ///////////////////////////
                // On s'occupe des stocks
                ///////////////////////////
                //if order
                /*$entitywmodelordered = $em->getRepository('AppBundle:RarOrder')->find($id);
                foreach ($entitywmodelordered->getModelsOrdered() as $modelOrdered) {
                    $idEntity = $modelOrdered->getId();
                    
                    $oldOrder = $em->getRepository('AppBundle:RarModelOrdered')->find($idEntity);
                    $oldStatus = $oldOrder->getStatus();
                    $newValue = $modelOrdered->getStatus();
                    
                    if($newValue >= 2 && $oldStatus < 2){
                        // Ici on vient creée une ligne de stock négative pour chaque matière commandée.
                        // On prend le modèle
                        $model = $modelOrdered->getModel();
                        // On récupérer la commande
                        $order = $modelOrdered->getOrder();
                        // On prend les matieres associées
                        $matters = $model->getMatterAttributed();
                        // On prend le provider en charge de cette création
                        $workroom = $modelOrdered->getWorkroom();
                        $em = $this->getDoctrine()->getManager();
                        foreach ($matters as $key => $matterAttributed) {
                            // On prend la quantité 
                            $quantity = $matterAttributed->getQuantity();
                            $matter = $matterAttributed->getMatter();
                            //On crée une ligne de stock
                            $stock = new RarStockLog();
                            $stock->setQuantity('-'.$quantity);
                            $stock->setWorkroom($workroom);
                            $stock->setMatter($matter);
                            $stock->setDateCreation($time);
                            $stock->setOrder($order);
                            $em->persist($stock);
                            $em->flush();
                        }
                    }
                    // On store le Log.
                    switch($newValue){
                        case 0: $stateWord ='to do'; break;
                        case 1: $stateWord ='in stock'; break;
                        case 2: $stateWord ='sent to workroom'; break;
                        case 3: $stateWord ='in production'; break;
                        case 4: $stateWord ='sent by workroom'; break;
                        case 5: $stateWord ='received by rime arodaky'; break;
                        case 6: $stateWord ='received by rime arodaky with error'; break;
                        case 7: $stateWord ='controled';break;
                        case 8: $stateWord ='delivered'; break;
                        case 9: $stateWord ='finished'; break;
                    }
                    //dump($modelOrdered);
                    if($modelOrdered->getModel()){
                        $model = $modelOrdered->getModel();
                        $modelName = $model->getName();
                        $newOrderLog = new RarOrderLog();
                        $newOrderLog->setDate($time);
                        $newOrderLog->setMessage('The order has been modified. Statuf of "'.$modelName.'" was set to "'.$stateWord.'" by '.$name.'.');
                        $newOrderLog->setOrder($entity);
                        $newOrderLog->setModelOrdered($modelOrdered);
                        $newOrderLog->setUser($user);
                        $em->persist($newOrderLog);
                        $em->flush();
                    }
                }*/
                

                /////////////////////////////////////////////////////
                // Order status
                $status = $entity->getState();
                $newNote = new RarOrderNotes();
                if( $form->get('note')->getData() != ''){
                    $data = $form->get('note')->getData();
                    $newNote->setComment($data);
                    $newNote->setDateCreation($time);
                    $newNote->setStatus('0');
                    $newNote->setOrder($entity);
                    $newNote->setUser($user);
                    $em->persist($newNote);
                    $em->flush();

                    // On store le Log.
                    $newOrderLog = new RarOrderLog();
                    $newOrderLog->setDate($time);
                    $newOrderLog->setMessage('A note has been added by '.$name.'.');
                    $newOrderLog->setOrder($entity);
                    $newOrderLog->setUser($user);
                    $em->persist($newOrderLog);
                    $em->flush();
                }
                

                //////////////////////////////////////////
                //              ATTENTION
                //////////////////////////////////////////
                // Recupérer le statut de la commande avant de faire l'upload
                //////////////////////////////////////////

                // Set Date Order
                if($entity->getState() == '1'){
                    // Get Year
                    $monthNum = date('m');
                    if( intval($monthNum) >=9 ){
                        $yearnum = date('y');
                        $year = intval($yearnum)+1;
                    }else{
                        $year = date('y');
                    }

                    
                    $entity->setDateOrder($time);

                    // Set Id Compta
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
                    $entity->setIdCompta($idCompta);
                    $entity->setYear($year);
                }
                // Save Order
                //----------------------------------
                $em->persist($entity);
                $em->flush();
                // Save Order Log
                //----------------------------------
                $newOrderLog = new RarOrderLog();
                $newOrderLog->setDate($time);
                $newOrderLog->setMessage('The order has been modified. Status of the order was set to "'.$status.'" by '.$name.'.');
                $newOrderLog->setOrder($entity);
                $newOrderLog->setUser($user);
                $em->persist($newOrderLog);
                $em->flush();

                // Recup Order ID
                $idOrder = $entity->getId();
                //-------------------------------
                // Update OrderID on ModelOrdered
                //-------------------------------
                /*foreach ( $entity->getModelsOrdered() as $model ){
                    if( $model->getModel() ){

                        // Pour les produits modifiés sur la page d'édition
                        // ** On récupère les prix variables de la taille ** //
                        $repositoryOrder = $this->getDoctrine()->getRepository(RarSize::class);
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
                        
                        if( $status == 0 ){
                        // if Draft :
                            // Do nothing about Shipping Date

                        }else if( $status == 1 ){
                            $baseDate = $entity->getDateMinShip();
                        // if Published :
                            $minDateShip = $baseDate->modify('-2 weeks');
                            $model->setMinProdShip($minDateShip);
                            $maxDateShip = $baseDate->modify('-1 week');
                            $model->setMaxProdShip($maxDateShip);
                            if($shopStatus == 1){
                            // ** Si directCustomer
                                if($vatStatus == 1){
                                    $priceSold = $model->getModel()->getPrixHT();
                                    $tvaAmount = $priceSold*$amountVAT/100;
                                    $price = $tvaAmount+$priceSold;
                                }else{
                                    $price = $model->getModel()->getPrixHT();
                                }
                            
                            }elseif($contractStatus == 1){
                            // ** Si la boutique achete RA a un prix contractualisé
                                if($vatStatus == 1){
                                    $priceSold = $model->getModel()->getPrixHT();
                                    $tvaAmount = ($priceSold+$pricesSize[0]['supHt'])*$amountVAT/100;
                                    $price = ($tvaAmount+$priceSold)*($contractAmount/100);
                                }else{
                                    $price = ($model->getModel()->getPrixHT()+$pricesSize[0]['supShop'])*($contractAmount/100);
                                }
                            }else{
                            // ** Si Vente Boutique
                                if($vatStatus == 1){
                                    $priceSold = $model->getModel()->getPrixShop();
                                    $tvaAmount = $priceSold*$amountVAT/100;
                                    $price = $tvaAmount+$priceSold;
                                }else{
                                    $price = $model->getModel()->getPrixShop();
                                }
                            }
                            $model->setPrixSoldHT($price);
                            $model->setOrder($entity);
                            $em->flush();
                        }
                    }
                }*/
                //-------------------------------
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('orders');
            }

            return $this->render('orders/order/editorder.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans($h1),
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
                    'form' => $form->createView(),
                    'notes' => $notes,
                    'customer' => $customer,
                    'shop' => $shop,
                    'customerAllow' => $customerAllow,
                    'order' => $entity,
                    'modelslist' => $modellist,
                    //'debug' => $request,
                )
            );

        }else{
            return $this->redirect('login');
        }
    }
}