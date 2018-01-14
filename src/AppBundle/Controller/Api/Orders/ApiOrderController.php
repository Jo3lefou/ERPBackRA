<?php

namespace AppBundle\Controller\Api\Orders;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\User;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarShop;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiOrderController extends Controller
{

	/**
     * @Route("/api/order/create", name="apiordercreate")
     */
	public function indexAction(Request $request)
	{
        //$user = $this->get('security.token_storage')->getToken()->getUser();
        //$configuration = $user->getConfiguration();

		//if ( $request->isXMLHttpRequest() ){

            //$em = $this->getDoctrine()->getManager();
            //$dataToSave = $request->get('data');

            $params = array();
            $content = $request->getContent();

            if (!empty($content)){
                // On décode :
                $params = json_decode($content, true); // 2nd param to get as array
                // On check les droits
                if($params['token'] == 'mKFsznxnUryr3sNpGeQWFcIIc9Q73GZR'){
                    // Initialisation du manager doctrine
                    $em = $this->getDoctrine()->getManager();

                    // Nouvelle commande
                    $newOrder = new RarOrder();
                    // On set la boutique
                    // On chercher la boutique par Token plus tard ;)
                    $shoprepository = $this->getDoctrine()->getRepository(RarShop::class);
                    $shop = $shoprepository->findOneById(5);
                    $newOrder->setShop($shop);
                    // Donnée boutique
                    $shopStatus = $shop->getIsDirectCustomer();
                    $vatStatus = $shop->getIsVat();
                    $contractStatus = $shop->getIsContract();
                    $contractAmount = $shop->getAmountContract();
                    $amountVAT = $shop->getAmountVat();

                    // On set le user
                    $userrepository = $this->getDoctrine()->getRepository(User::class);
                    $user = $userrepository->findOneById(15);
                    $newOrder->setUser($user);

                    //Repository 
                    $customerrepository = $this->getDoctrine()->getRepository(RarCustomer::class);
                    $alreadyuser = $customerrepository->findOneBy( [ "email" => $params['Email'] ] );

                    if($alreadyuser != null){
                        $newCustomer = $alreadyuser;
                    }else{
                        // Nouveau client
                        $newCustomer = new RarCustomer();
                        $newCustomer->setDateModification(date_create(date('Y/m/d H:i:s')));
                        $newCustomer->setDateCreation(date_create(date('Y/m/d H:i:s')));
                        $newCustomer->setFirstName($params['firstName']);
                        $newCustomer->setLastName($params['Name']);
                        $newCustomer->setAddress($params['Address']);
                        $newCustomer->setPostCode($params['PostalCode']);
                        $newCustomer->setCity($params['City']);
                        $newCustomer->setCountry($params['Country']);
                        $newCustomer->setPhone($params['Phone']);
                        $newCustomer->setEmail($params['Email']);
                        $em->persist($newCustomer);
                        $em->flush();
                    }
                    // On set le Customer
                    $newOrder->setCustomer($newCustomer);
                    // On set le Type
                    $newOrder->setType(0);
                    // Conception Numero de Commande
                    $monthNum = date('m');
                    if( intval($monthNum) >=9 ){
                        $yearnum = date('y');
                        $year = intval($yearnum)+1;
                    }else{
                        $year = date('y');
                    }
                    // ** Set Id Compta
                    $repositoryOrder = $this->getDoctrine()->getRepository(RarOrder::class);
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
                    // On set l'état
                    $newOrder->setState(2);

                    // ** Set Date Creation
                    $time = date_create(date('Y/m/d H:i:s'));
                    $newOrder->setDateOrder($time);

                    // On sauve la commande : 
                    $em->persist($newOrder);
                    $em->flush();


                    $message = 'Merci '.$firstName.' '.$name;

                    // OLD VERSION
                    foreach ($params['Products'] as $key => $product) {

                        $message .= '<br/>Produit : '.$product['Nom'].' ('.$product['SKU'].') à '.$product['Price'].' €';

                        // On recherche le Produit :
                        $productrepository = $this->getDoctrine()->getRepository(RarModel::class);
                        $resultPdt = $productrepository->createQueryBuilder('p')
                            ->where("p.sku = ?1")
                            ->setParameter(1, $product['SKU'])
                            ->getQuery()
                            ->getResult();
                        $newModelOrdered = new RarModelOrdered();

                         


                    }





                }else{
                    $message = 'Access forbiden';
                }
            }else{
                $message = 'Content empty';
            }
            return new Response($message, 400);
            /*
            $em->persist($configuration);
            $em->flush();
            $response = array('response' => 'ok');

            $encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($response, 'json'));
            */
		//}
        //return new Response('This is not ajax! 2', 400);
	}
}