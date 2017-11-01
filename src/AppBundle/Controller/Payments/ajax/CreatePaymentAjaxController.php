<?php

namespace AppBundle\Controller\Payments\ajax;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarPayment;
use AppBundle\Entity\RarOrderLog;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CreatePaymentAjaxController extends Controller
{

	/**
     * @Route("/{_locale}/payments/create/{id}", name="createpayment")
     */
	public function indexAction($id, Request $request)
	{
		if( $request->get('amount') && $request->get('datePaiement') && $request->get('typePaiement') && $request->get('dateCashing') ){

			// User
			$user = $this->get('security.token_storage')->getToken()->getUser();
			$firstName = $this->getUser()->getLastName();
        	$lastName = $this->getUser()->getFirstName();
        	$name = $firstName.' '.$lastName;
			// Order
			$em = $this->getDoctrine()->getManager();
			$order = $em->getRepository('AppBundle:RarOrder')->find($id);
			// Initialisation des données
			$amount = $request->get('amount');
			$datePaiement = $request->get('datePaiement');
			//$datePaiement = DateTime::createFromFormat('d.m.Y', $datePaiement);
			$dateCashing = $request->get('dateCashing');
			//$dateCashing = DateTime::createFromFormat('d.m.Y', $datePaiement);
			$typePaiement = $request->get('typePaiement');
			$comment = $request->get('comment');
			$time = date_create(date('Y/m/d H:i:s'));

			$payment = new RarPayment();
			$payment->setAmount($amount);
			$payment->setDatePaiement(\DateTime::createFromFormat('d.m.Y',$datePaiement));
			$payment->setDateCashing(\DateTime::createFromFormat('d.m.Y',$dateCashing));
			$payment->setTypePaiement($typePaiement);
			$payment->setComment($comment);
			$payment->setDateCreated($time);
			$payment->setOrder($order);
			$payment->setUser($user);
			$em->persist($payment);
			$em->flush();

			$message = 'An amount of '.$amount.' € has been added to the order by '.$name;
			$newOrderLog = new RarOrderLog();
	        $newOrderLog->setDate($time);
	        $newOrderLog->setMessage($message);
	        $newOrderLog->setOrder($order);
	        $em->persist($newOrderLog);
	        $em->flush();

	        $datePaiementJson = \DateTime::createFromFormat('d.m.Y',$datePaiement);
	        $dateCashJson = \DateTime::createFromFormat('d.m.Y',$dateCashing);

			$response = array(
				'amount' => $amount,
				'datePaid' => $datePaiementJson->format('d/m/Y'),
				'dateCash' => $dateCashJson->format('d/m/Y'),
				'type' => $typePaiement,
				'comment' => $comment,
				'time'=> $time,
				'error'=> '',
				'log'=>$message,
				'logTime'=>$time->format('d/m/Y H:i:s'),
			);


			
		}else{

			$error = '#0004 : No data defined in the request';
			$response = array(
				'error' => $error,
			);

		}

		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
    	$serializer = new Serializer($normalizers, $encoders);
		return new Response($serializer->serialize($response, 'json'));

	}
}