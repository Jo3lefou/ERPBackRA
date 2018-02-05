<?php

namespace AppBundle\Controller\Customer\ajax;

use AppBundle\Entity\RarNotes;
use AppBundle\Entity\RarCustomer;

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

class AddNoteAjaxController extends Controller
{

	/**
     * @Route("/{_locale}/notes/create/{id}", name="ajaxaddnote")
     */
	public function indexAction($id, Request $request)
	{
        // User
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // Customer
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->findOneBy(['id' => $id]);
        $dataToSave = $request->get('data');
        // time
        $time = date_create(date('Y/m/d H:i:s'));

		if ( $request->isXMLHttpRequest() ){
            // Creation Note
            $newNotes = new RarNotes();
            $newNotes->setNote($dataToSave);
            $newNotes->setCustomer($customer);
            $newNotes->setUser($user);
            $newNotes->setDateCreation();

            $em->persist($newNotes);
            $em->flush();
            
            $response = array('response' => 'ok');

            $encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($response, 'json'));

		}
        return new Response('This is not ajax!', 400);
	}
}