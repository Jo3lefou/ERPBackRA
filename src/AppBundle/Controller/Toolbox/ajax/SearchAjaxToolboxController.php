<?php

namespace AppBundle\Controller\Toolbox\ajax;

use AppBundle\Entity\RarModelOrdered;

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


class SearchAjaxToolboxController extends Controller
{

	/**
     * @Route("/{_locale}/prodtoolbox/ajaxsearchexpedition/{action}", name="ajaxsearchtoolbox")
     * @Method({"POST"})
     */
	public function indexAction($action, Request $request)
	{
        // User
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid = $user->getId();
        // $EM
        $em = $this->getDoctrine()->getManager();
        // Time
        $time = date_create(date('Y/m/d H:i:s'));

        if ( $request->isXMLHttpRequest() ){

        	$response = "";
        	// Instancie le repository
        	$repository = $this->getDoctrine()->getRepository(RarModelOrdered::class);

        	if($action == '1'){
        		$idshop = $request->get('value');
        		$date = new \DateTime('+1 month');

        		$dql = "SELECT
        			x.id AS idProd,
        			CONCAT('#',c.extention,a.year,'-',a.idCompta) AS id,
        			CASE WHEN b.firstName != '' THEN CONCAT(b.firstName,' ',b.lastName) ELSE a.customerName END AS customerName,
        			a.type AS orderType,
        			DATE_FORMAT(a.dateCivil, '%Y/%m/%d') AS weddingDate,
					DATE_FORMAT(a.dateOrder, '%Y/%m/%d') AS orderDate,
					DATE_FORMAT(a.dateValidation, '%Y/%m/%d') AS validationDate,
					DATE_FORMAT(a.dateMinShip, '%Y/%m/%d') AS minShippingDate,
					DATE_FORMAT(a.dateMaxShip, '%Y/%m/%d') AS maxShippingDate,
					DATE_FORMAT(a.dateShipped, '%Y/%m/%d') AS shippingDate,
					d.name AS modelName,
					d.sku AS sku,
					DATE_FORMAT(x.minProdShip, '%Y/%m/%d') AS maxShip,
					DATE_FORMAT(x.maxProdShip, '%Y/%m/%d') AS minShip,
					x.heels AS length,
					x.size AS sire
					FROM AppBundle:RarModelOrdered x
					INNER JOIN x.order a
					LEFT JOIN a.customer b
					INNER JOIN a.shop c
					INNER JOIN x.model d
					INNER JOIN c.users e
					WHERE c.id = ".$idshop." AND x.minProdShip BETWEEN NOW() AND '".$date->format("Y-m-d H:i")."'
					AND x.status > 1 AND x.status < 5 AND e.id = ".$userid;
        
		        $query = $em->createQuery($dql);
		        $response = $query->getResult();
        	}else if($action == '2'){
        		$idshop = $request->get('value');
        		$date = new \DateTime('+1 month');
        		$dateplus = new \DateTime('+2 month');

        		$dql = "SELECT
        			x.id AS idProd,
        			CONCAT('#',c.extention,a.year,'-',a.idCompta) AS id,
        			CASE WHEN b.firstName != '' THEN CONCAT(b.firstName,' ',b.lastName) ELSE a.customerName END AS customerName,
        			a.type AS orderType,
        			DATE_FORMAT(a.dateCivil, '%Y/%m/%d') AS weddingDate,
					DATE_FORMAT(a.dateOrder, '%Y/%m/%d') AS orderDate,
					DATE_FORMAT(a.dateValidation, '%Y/%m/%d') AS validationDate,
					DATE_FORMAT(a.dateMinShip, '%Y/%m/%d') AS minShippingDate,
					DATE_FORMAT(a.dateMaxShip, '%Y/%m/%d') AS maxShippingDate,
					DATE_FORMAT(a.dateShipped, '%Y/%m/%d') AS shippingDate,
					d.name AS modelName,
					d.sku AS sku,
					DATE_FORMAT(x.minProdShip, '%Y/%m/%d') AS maxShip,
					DATE_FORMAT(x.maxProdShip, '%Y/%m/%d') AS minShip,
					x.heels AS length,
					x.size AS sire
					FROM AppBundle:RarModelOrdered x
					INNER JOIN x.order a
					LEFT JOIN a.customer b
					INNER JOIN a.shop c
					INNER JOIN x.model d
					INNER JOIN c.users e
					WHERE c.id = ".$idshop." AND x.minProdShip BETWEEN '".$date->format("Y-m-d H:i")."' AND '".$dateplus->format("Y-m-d H:i")."'
					AND x.status > 1 AND x.status < 5 AND e.id = ".$userid;
        
		        $query = $em->createQuery($dql);
		        $response = $query->getResult();
        	}
        	return new Response(json_encode($response, 200));
	    }
	    return new Response('This is not ajax!', 400);

	}
}