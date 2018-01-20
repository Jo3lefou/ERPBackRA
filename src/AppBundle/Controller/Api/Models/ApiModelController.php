<?php

namespace AppBundle\Controller\Api\Models;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\User;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarShop;
use AppBundle\Entity\RarModel;

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

class ApiModelController extends Controller
{

	/**
     * @Route("/api/model/create", name="apiordercreate")
     */
	public function indexAction(Request $request)
	{
            $params = array();
            $content = $request->getContent();

            if (!empty($content)){
                // On décode :
                $params = json_decode($content, true); // 2nd param to get as array
                // On check les droits
                if( $params['tokenUser'] != '' ){
                    // Initialisation du manager doctrine
                    $em = $this->getDoctrine()->getManager();
                    

                }else{
                    $message = 'Access forbiden';
                }
            }else{
                $message = 'Content empty';
            }
            return new Response($message, 400);
	}
}