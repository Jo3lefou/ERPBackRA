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
     * @Route("/api/model/create", name="apimodelcreate")
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
                    
                    //Repository 
                    $modelrepository = $this->getDoctrine()->getRepository(RarModel::class);
                    $alreadymodel = $modelrepository->findOneBy( [ "fkEshop" => $params['fkEshop'] ] );

                    if($alreadymodel != null){
                        $alreadymodel->setSku($params['sku']);
                        $alreadymodel->setName($params['name']);
                        $alreadymodel->setPrixHT($params['prixHT']);
                        $alreadymodel->setPrixShop("0");
                        $alreadymodel->setUrlImg($params['url_img']);
                        $alreadymodel->setFkEshop($params['fkEshop']);
                        $em->persist($alreadymodel);
                        $em->flush();
                        $message = 'Update done';
                        $message .= '<br/> La robe '.$params['name'].'a bien été uploadée.';
                    }else{
                        $newModel = new RarModel();
                        $newModel->setCollectionId($params['collectionId']);
                        $newModel->setIsActive($params['is_active']);
                        $newModel->setIsShop($params['is_shop']);
                        $newModel->setIsContract($params['is_contract']);
                        $newModel->setType($params['type']);
                        $newModel->setCategory($params['category']);
                        $newModel->setMinShipWeek($params['min_ship_week']);
                        $newModel->setMaxShipWeek($params['max_ship_week']);
                        $newModel->setFkEshop($params['fkEshop']);
                        $newModel->setSku($params['sku']);
                        $newModel->setName($params['name']);
                        $newModel->setPrixHT($params['prixHT']);
                        $newModel->setPrixShop("0");
                        $newModel->setUrlImg($params['url_img']);
                        $em->persist($newModel);
                        $em->flush();
                        $message = 'Creation done';
                        $message .= '<br/> La robe '.$params['name'].'a bien été créée.';
                    }
                    

                }else{
                    $message = 'Access forbiden';
                }
            }else{
                $message = 'Content empty';
            }
            return new Response($message, 400);
	}
}