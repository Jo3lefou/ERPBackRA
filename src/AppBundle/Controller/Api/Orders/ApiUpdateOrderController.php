<?php

namespace AppBundle\Controller\Api\Orders;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\User;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarOrderLog;

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

class ApiUpdateOrderController extends Controller
{

	/**
     * @Route("/api/order/update", name="apiupdateorder")
     */
	public function indexAction(Request $request){

            $params = array();
            $content = $request->getContent();
            $time = date_create(date('Y/m/d H:i:s'));

            if (!empty($content)){
                // On décode :
                $params = json_decode($content, true); // 2nd param to get as array
                // On check les droits
                if($params['tokenUser'] != ''){

                    // Initialisation du manager doctrine
                    $em = $this->getDoctrine()->getManager();
                    $orderrepository = $this->getDoctrine()->getRepository(RarOrder::class);
                    $order = $orderrepository->findOneBy( [ "idEshop" => $params['fk_shop'] ] );
                    // On récupère l'utilisateur
                    $userrepository = $this->getDoctrine()->getRepository(User::class);
                    $user = $userrepository->findOneBy([ "token" => $params['tokenUser'] ]);
                    $firstName = $user->getFirstName();
                    $lastName = $user->getLastName();
                    $fullName = $firstName.' '.$lastName;

                    if($params['action'] == 'canceled'){
                        $order->setState('3');
                        $stateWord = 'canceled';
                    }

                    if($params['action'] == 'complete'){
                        $order->setState('6');
                        $order->setDateShipped(date_create(date('Y/m/d H:i:s')));
                        $stateWord = 'finished';
                    }

                    $em->persist($order);
                    $em->flush();

                    // Notification
                    $newOrderLog = new RarOrderLog();
                    $newOrderLog->setDate($time);
                    $newOrderLog->setMessage('Order #'.$params['fk_shop'].' status updated to "'.$stateWord.'" par '.$fullName.'.');
                    $newOrderLog->setOrder($order);
                    $em->persist($newOrderLog);
                    $em->flush();

                    $message = 'Done';

                }else{
                    $message = 'Access forbiden';
                }
            }else{
                $message = 'Content empty';
            }
            return new Response($message, 400);
	}
}