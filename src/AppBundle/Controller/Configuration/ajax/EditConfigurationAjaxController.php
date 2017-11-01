<?php

namespace AppBundle\Controller\Configuration\ajax;

use AppBundle\Entity\RarConfiguration;

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

class EditConfigurationAjaxController extends Controller
{

	/**
     * @Route("/{_locale}/admin/configuration/text", name="ajaxconfiguration")
     */
	public function indexAction(Request $request)
	{
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $configuration = $user->getConfiguration();

		if ( $request->isXMLHttpRequest() ){

            $em = $this->getDoctrine()->getManager();
            $dataToSave = $request->get('data');
            
            if($request->get('action') == 'orderCondition'){
                $configuration->setOrderCondition($dataToSave);
            }elseif ($request->get('action') == 'orderConditionEn') {
                $configuration->setOrderConditionEn($dataToSave);
            }elseif ($request->get('action') == 'saleCondition') {
                $configuration->setSaleCondition($dataToSave);
            }elseif ($request->get('action') == 'saleConditionEn') {
                $configuration->setSaleConditionEn($dataToSave);
            }

            $em->persist($configuration);
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