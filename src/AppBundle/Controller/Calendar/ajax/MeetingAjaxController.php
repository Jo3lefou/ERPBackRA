<?php

namespace AppBundle\Controller\Calendar\ajax;

use AppBundle\Entity\RarMeeting;

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
	public function indexAction($action = 'null', $id = 'null' , Request $request)
	{
        // User
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // $EM
        $em = $this->getDoctrine()->getManager();
        // Time
        $time = date_create(date('Y/m/d H:i:s'));

        if ( $request->isXMLHttpRequest() ){
	        if($action == 'add'){
	        	//Creation
				$meeting = new RarMeeting();
				$dataToSave = $request->get('data');

				$response = array('response' => 'ok');
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
	        	// End
	        	$dataEnd = $request->get('end');
	        	$endTime = new \DateTime($dataEnd);
	        	// // DATE
	        	$dataComment = $request->get('comment');
	        	$dataLocation = $request->get('location');
	        	$dataType = $request->get('type');
	        	$dataSale = $request->get('sale');


	        	$meeting->setName($dataTitle);
	        	$meeting->setStartDate($startTime);
	        	$meeting->setEndDate($endTime);
	        	$meeting->setComment($dataComment);
	        	$meeting->setType($dataType);
	        	//$meeting->setLocation($dataLocation);
	        	//$meeting->setSale($dataSale);



	        	$response = array('response' => 'ok');
	        }elseif($action == 'cancel'){
	        	$meeting = $em->getRepository('AppBundle:RarMeeting')->findOneBy(['id' => $id]);
	        	// {id:id,title:title,start:start,end:end,comment:comment,location:location,type:type,sale:sale}
	        	//Delete


	        	$response = array('response' => 'ok');
	        }
	        // On sauve le meeting
	        $em->persist($meeting);
            $em->flush();

	        $encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($response, 'json'));
	    }
	    return new Response('This is not ajax!', 400);

	}
}