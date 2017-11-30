<?php

namespace AppBundle\Controller\Api\Orders;

use AppBundle\Entity\RarOrder;
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
                    $firstName = $params['firstName'];
                    $name = $params['Name'];
                    $address = $params['Address'];
                    $city = $params['City'];
                    $postCode = $params['PostalCode'];
                    $country = $params['Country'];
                    $phone = $params['Phone'];
                    $email = $params['Email'];
                    $message = 'Merci '.$firstName.' '.$name;
                    foreach ($params['Products'] as $key => $product) {
                        $message .= '<br/>Produit : '.$product['Nom'].' ('.$product['SKU'].') à '.$product['Price'].' €';
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