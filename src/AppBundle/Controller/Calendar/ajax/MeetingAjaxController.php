<?php

namespace AppBundle\Controller\Calendar\ajax;

use AppBundle\Entity\RarMeeting;
use AppBundle\Entity\RarCustomer;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Validator\Constraints\DateTime;


class MeetingAjaxController extends Controller
{

	/**
     * @Route("/{_locale}/meeting/{action}/{id}", name="ajaxeditmeeting")
     * @Method({"POST"})
     */
	public function indexAction($action = 'null', $id = 'null' , Request $request, \Swift_Mailer $mailer)
	{
        // User
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // $EM
        $em = $this->getDoctrine()->getManager();
        // Time
        $time = date_create(date('Y/m/d H:i:s'));

        if ( $request->isXMLHttpRequest() ){
	        if($action == 'add'){
	        	
	        	$dataCustomerexist = $request->get('customerexist');
				if($dataCustomerexist == false){
					///User Does not EXIST
					$customer = new RarCustomer;

					$dataSalutation = $request->get('salutation');
					$dataFirstName = $request->get('firstname');
					$dataLastName = $request->get('lastname');
					$dataAddress = $request->get('address');
					$dataEmail = $request->get('email');
					$dataPostCode = $request->get('postcode');
					$dataCity = $request->get('city');
					$dataState = $request->get('state');
					$dataCountry = $request->get('country');
					$dataPhone = $request->get('phone');
					$dataOptin = $request->get('optin');
					$dataLang = $request->get('lang');


					$customer->setSalutation($dataSalutation);
					$customer->setFirstName($dataFirstName);
					$customer->setLastName($dataLastName);
					$customer->setAddress($dataAddress);
					$customer->setPostCode($dataPostCode);
					$customer->setCity($dataCity);
					$customer->setState($dataState);
					$customer->setCountry($dataCountry);
					$customer->setPhone($dataPhone);
					$customer->setEmail($dataEmail);
					$customer->setOptin($dataOptin);
					$customer->setLocale($dataLang);

					$em->persist($customer);
            		$em->flush();

            		$dataCusId = $customer->getId();
            		$dataCusLang = $customer->getLocale();
            		$dataCusEmail = $customer->getEmail();

				}else{
					///User  EXIST
					// search for customer
					$dataCusId = $request->get('cusId');
					$customer = $em->getRepository('AppBundle:RarCustomer')->findOneBy(['id' => $dataCusId]);
					$dataCusLang = $customer->getLocale();
					$dataCusEmail = $customer->getEmail();
					
				}
				
				// STORE EVENT
				$meeting = new RarMeeting();

				$dataTitle = $request->get('title');
				$dataLieu = $request->get('lieu');
				$lieu = $em->getRepository('AppBundle:RarLocation')->findOneBy(['id' => $dataLieu]);
				$dataComment = $request->get('comment');
				$dataNotif = $request->get('notif');
				$dataType = $request->get('type');
				$dataSale = $request->get('sale');
				$sale = $em->getRepository('AppBundle:User')->findOneBy(['id' => $dataSale]);

				// DATE
	        	// Start
	        	$dataStart = $request->get('start');
	        	$startTime = new \DateTime($dataStart);
	        	$startEmailDate = $startTime->format('d/m/Y');
	        	$startEmailTime = $startTime->format('H:i');
	        	// End
	        	$dataEnd = $request->get('end');
	        	$endTime = new \DateTime($dataEnd);

	        	$meeting->setName($dataTitle);
	        	$meeting->setStartDate($startTime);
	        	$meeting->setEndDate($endTime);
	        	$meeting->setComment($dataComment);
	        	$meeting->setType($dataType);
	        	$meeting->setNotifStatus($dataNotif);
	        	$meeting->setSale($sale);
	        	$meeting->setCustomer($customer);
	        	$meeting->setCreationDate($time);
	        	$meeting->setLocation($lieu);
	        	$meeting->setState('0');
	        	$meeting->setUser($user);

	        	$saleColor = $sale->getUserColor();

	        	// On sauve le meeting
		        $em->persist($meeting);
	            $em->flush();
	            $idMeeting = $meeting->getId();
	            $location = $meeting->getLocation();

	            $configuration = $user->getConfiguration();
	            if($dataCusLang == 'fr'){
	            	if($dataType == '1'){
	            		$content = $configuration->getEmailRdvOne();
	            		$view = 'email/confirmation1stMeeting.html.twig';
	            	}else{
	            		$content = $configuration->getEmailRdvConf();
	            		$view = 'email/confirmationMeeting.html.twig';
	            	}
	            	$subject = 'Rime Arodaky - Confirmation de votre rendez-vous';
	            }else if($dataCusLang == 'en'){
	            	if($dataType == '1'){
	            		$content = $configuration->getEmailRdvOneEn();
	            		$view = 'email/confirmation1stMeeting.html.twig';
	            	}else{
	            		$content = $configuration->getEmailRdvConfEn();
	            		$view = 'email/confirmationMeeting.html.twig';
	            	}
	            	$subject = 'Rime Arodaky - Meeting Confirmation';
	            }
	            // ****** NOTIFICATION EMAIL ******* //
                $message = (new \Swift_Message($subject))
                    ->setFrom('notification@rime-arodaky.com')
                    ->setTo($dataCusEmail)
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView( $view,
                        array('locale' => $dataCusLang, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'location' => $location, 'date' => $startEmailDate, 'time' => $startEmailTime) )
                    );
                $mailer->send($message);
                // ****** NOTIFICATION EMAIL ******* //


				$response = array('response' => 'ok', 'color' => $saleColor, 'cusId' => $dataCusId, 'idMeeting' => $idMeeting);
	        }elseif($action == 'edit'){

	        	$meeting = $em->getRepository('AppBundle:RarMeeting')->findOneBy(['id' => $id]);
	        	// Modify
	        	// {id:id,title:title,start:start,end:end,comment:comment,location:location,type:type,sale:sale}
	        	$dataId = $request->get('id');
	        	$dataTitle = $request->get('title');
	        	// DATE
	        	// Start
	        	$dataStart = $request->get('start');
	        	$startTime = new \DateTime($dataStart);
	        	$startEmailDate = $startTime->format('d/m/Y');
	        	$startEmailTime = $startTime->format('H:i');
	        	// End
	        	$dataEnd = $request->get('end');
	        	$endTime = new \DateTime($dataEnd);
	        	// // DATE
	        	$dataComment = $request->get('comment');
	        	$dataLocation = $request->get('location');
	        	$lieu = $em->getRepository('AppBundle:RarLocation')->findOneBy(['id' => $dataLocation]);
	        	$dataType = $request->get('type');
	        	$dataSale = $request->get('sale');
				$sale = $em->getRepository('AppBundle:User')->findOneBy(['id' => $dataSale]);
				$dataNotif = $request->get('notif');

	        	$meeting->setName($dataTitle);
	        	$meeting->setStartDate($startTime);
	        	$meeting->setEndDate($endTime);
	        	$meeting->setComment($dataComment);
	        	$meeting->setType($dataType);
	        	$meeting->setLocation($lieu);
	        	$meeting->setSale($sale);
	        	$meeting->setNotifStatus($dataNotif);


	        	$customer = $meeting->getCustomer();
	        	$dataCusEmail = $customer->getEmail();
	        	$dataCusLang = $customer->getLocale();
	        	$configuration = $user->getConfiguration();
	            if($dataCusLang == 'fr'){
	            	$content = $configuration->getEmailRdvEdition();
	            	$subject = 'Rime Arodaky - Modification de votre rendez-vous';
	            }else if($dataCusLang == 'fr'){
	            	$content = $configuration->getEmailRdvEditionEn();
	            	$subject = 'Rime Arodaky - Meeting modification';
	            }

	        	// On sauve le meeting
		        $em->persist($meeting);
	            $em->flush();
	            $location = $meeting->getLocation();

	            return $this->renderView( 'email/editionMeeting.html.twig', array('locale' => $dataCusLang, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'location' => $location, 'date' => $startEmailDate, 'time' => $startEmailTime) );
	            // ****** NOTIFICATION EMAIL ******* //
                /*$message = (new \Swift_Message($subject))
                    ->setFrom('notification@rime-arodaky.com')
                    ->setTo($dataCusEmail)
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView( 'email/editionMeeting.html.twig',
                        array('locale' => $dataCusLang, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'location' => $location, 'date' => $startEmailDate, 'time' => $startEmailTime) )
                    );
                $mailer->send($message);*/
                // ****** NOTIFICATION EMAIL ******* //

	        	$response = array('response' => 'ok');
	        }elseif($action == 'cancel'){

	        	$dataComment = 'RAS';
	        	$dataComment = $request->get('comment');
	        	$meeting = $em->getRepository('AppBundle:RarMeeting')->findOneBy(['id' => $id]);
	        	$startTime = $meeting->getStartDate();
	        	$startEmailDate = $startTime->format('d/m/Y');
	        	$startEmailTime = $startTime->format('H:i');

	        	$customer = $meeting->getCustomer();
	        	$dataCusEmail = $customer->getEmail();
	        	$dataCusLang = $customer->getLocale();
	        	$configuration = $user->getConfiguration();
	            if($dataCusLang == 'fr'){
	            	$content = $configuration->getEmailRdvCancelation();
	            	$subject = 'Rime Arodaky - Annulation de votre rendez-vous';
	            }else if($dataCusLang == 'fr'){
	            	$content = $configuration->getEmailRdvCancelationEn();
	            	$subject = 'Rime Arodaky - Meeting cancelation';
	            }
	        	//Change STATE TO 2

				$meeting->setComment($dataComment);
				$meeting->setState('2');
	        	$em->persist($meeting);
	        	$em->flush();

	        	// ****** NOTIFICATION EMAIL ******* //
                $message = (new \Swift_Message($subject))
                    ->setFrom('notification@rime-arodaky.com')
                    ->setTo($dataCusEmail)
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView( 'email/cancelationMeeting.html.twig',
                        array('locale' => $dataCusLang, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'date' => $startEmailDate, 'time' => $startEmailTime) )
                    );
                $mailer->send($message);
                // ****** NOTIFICATION EMAIL ******* //

	        	$response = array('response' => 'ok');
	        }
	        

	        $encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($response, 'json'));
	    }
	    return new Response('This is not ajax!', 400);

	}
}