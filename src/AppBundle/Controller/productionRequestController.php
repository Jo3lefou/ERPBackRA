<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RarProdBasket;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarOrderLog;
use AppBundle\Entity\RarWorkroom;
use AppBundle\Entity\RarStockLog;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\Query\ResultSetMapping;

class productionRequestController extends Controller
{
	public function indexAction(Request $request)
	{
		if($request->isXmlHttpRequest()){
			if( $request->get('action') || $request->get('elem') != '' ){
				$action = $request->get('action');
				$value = $request->get('value');
				$elem = $request->get('elem');

				// usefull
				$em = $this->getDoctrine()->getManager();
				$time = date_create(date('Y/m/d H:i:s'));
				$error = "";
				$valid = "";
				$arrayresponse = "";

				if($action == "state"){
					foreach ($elem as $key => $id){
						$entity = $em->getRepository('AppBundle:RarModelOrdered')->find($id);
						$order = $entity->getOrder();
						$model = $entity->getModel();
						$oldStatus = $entity->getStatus();
						$nameModel = $model->getName().' ('.$entity->getSize().')';

						switch($value){
		            		case 0: $class = 'btn btn-default dropdown-toggle btn-xs state st-td'; $lineClass = 'st-td'; $stateWord ='to do'; break;
		                    case 1: $class = 'btn btn-default dropdown-toggle btn-xs state st-es'; $lineClass = 'st-es'; $stateWord ='in stock'; break;
		                    case 2: $class = 'btn btn-default dropdown-toggle btn-xs state st-ew'; $lineClass = 'st-ew'; $stateWord ='sent to workroom'; break;
		                    case 3: $class = 'btn btn-default dropdown-toggle btn-xs state st-ecp'; $lineClass = 'st-ecp'; $stateWord ='in production'; break;
		                    case 4: $class = 'btn btn-default dropdown-toggle btn-xs state st-epf'; $lineClass = 'st-epf'; $stateWord ='sent by workroom'; break;
		                    case 5: $class = 'btn btn-default dropdown-toggle btn-xs state st-rs'; $lineClass = 'st-rs'; $stateWord ='received by rime arodaky'; break;
		                    case 6: $class = 'btn btn-default dropdown-toggle btn-xs state st-rse'; $lineClass = 'st-rse'; $stateWord ='received by rime arodaky with error'; break;
		                    case 7: $class = 'btn btn-default dropdown-toggle btn-xs state st-cs'; $lineClass = 'st-cs'; $stateWord ='controled';break;
		                    case 8: $class = 'btn btn-default dropdown-toggle btn-xs state st-lc'; $lineClass = 'st-lc'; $stateWord ='delivered'; break;
		                    case 9: $class = 'btn btn-default dropdown-toggle btn-xs state st-lc'; $lineClass = 'st-lc'; $stateWord ='finished'; break;
		            	}

		            	// on set les variables : 
		            	$entity->setStatus($value);
            			$entity->setDateModification($time);
            			if($value >= 2 && $oldStatus < 2){
            				// Ici on vient creée une ligne de stock négative pour chaque matière commandée.
		            		// On prend le modèle
		            		$model = $entity->getModel();
		            		// On récupérer la commande
		            		$order = $entity->getOrder();
		            		// On prend les matieres associées
		            		$matters = $model->getMatterAttributed();
		            		// On prend le provider en charge de cette création
		            		$workroom = $entity->getWorkroom();
		            		$em = $this->getDoctrine()->getManager();
		            		foreach ($matters as $key => $matterAttributed) {
		            			// On prend la quantité 
		            			$quantity = $matterAttributed->getQuantity();
		            			$matter = $matterAttributed->getMatter();
		            			//On crée une ligne de stock
		            			$stock = new RarStockLog();
		            			$stock->setQuantity('-'.$quantity);
		            			$stock->setWorkroom($workroom);
		            			$stock->setMatter($matter);
		            			$stock->setDateCreation($time);
		            			$stock->setOrder($order);
		            			$em->persist($stock);
		                		$em->flush();
		            		}
            			}
		                if( $value == 8){
		                    $entity->setDateShipping($time);
		                }
		                $em->persist($entity);
		                $em->flush();

		                // Create response
		                $arrayresponse[$key]['id'] = $id;
	                	$arrayresponse[$key]['state'] = $stateWord;
	                	$arrayresponse[$key]['class'] = $class;
	                	$arrayresponse[$key]['lineClass'] = $lineClass;

		                // Create Log
		                $newOrderLog = new RarOrderLog();
		                $newOrderLog->setDate($time);
		                $newOrderLog->setMessage('The status of the model '.$nameModel.' has been changed to "'.$stateWord.'"');
		                $newOrderLog->setOrder($order);
		                $newOrderLog->setModelOrdered($entity);
		                $em->persist($newOrderLog);
		                $em->flush();

					}
					$valid = "All model has been well updated, you are a star !";
				}elseif($action == "workroom"){
					foreach ($elem as $key => $id){
						$entity = $em->getRepository('AppBundle:RarModelOrdered')->find($id);
						$order = $entity->getOrder();
						$model = $entity->getModel();
						$nameModel = $model->getName().' ('.$entity->getSize().')';

						$workroom = $em->getRepository('AppBundle:RarWorkroom')->find($value);
						$nameWorkroom = $workroom->getName();
						$entity->setWorkroom($workroom);
						$em->persist($entity);
	                	$em->flush();
	                	$arrayresponse[$key]['id'] = $id;
	                	$arrayresponse[$key]['name'] = $nameWorkroom;
	                	/******************/
                		// Log sur le produit
                		$logText = 'The workroom for model "'.$nameModel.'" has been changed to '.$nameWorkroom.'.';
                		$newOrderLog = new RarOrderLog();
		                $newOrderLog->setDate($time);
		                $newOrderLog->setOrder($order);
		                $newOrderLog->setMessage($logText);
		                $newOrderLog->setModelOrdered($entity);
		                $em->persist($newOrderLog);
		                $em->flush();
					}
					$valid = "All model has been well updated, you are a star !";
				}elseif($action == "notify"){
					// Pour chaque elem on cherche l'objet "ModelOrdered"
					foreach ($elem as $key => $id){
						$entity = $em->getRepository('AppBundle:RarModelOrdered')->find($id);
						$order = $entity->getOrder();
						$model = $entity->getModel();
						$nameModel = $model->getName().' ('.$entity->getSize().')';

						$prodLog = $em->getRepository('AppBundle:RarProdBasket')->findBy( array( 'modelOrdered' => $entity->getId() ) );
						// usefull
						if($value == "log"){
							$valueNum = 1;
							$logText = 'Workroom has been notified about production of "'.$nameModel.'" by email.';
							$arrayresponse[$key]['id'] = $id;
						}elseif($value == "order"){
							$valueNum = 2;
							$logText = 'Production has been requested for "'.$nameModel.'" to the workroom.';
						}
						if($prodLog == null){
							$newProdBasketLog = new RarProdBasket();
							$newProdBasketLog->setCreationDate($time);
							$newProdBasketLog->setModelOrdered($entity);
							$newProdBasketLog->setStatus($valueNum);
							$em->persist($newProdBasketLog);
	                		$em->flush();
	                		/******************/
	                		// Log sur le produit
	                		$newOrderLog = new RarOrderLog();
			                $newOrderLog->setDate($time);
			                $newOrderLog->setOrder($order);
			                $newOrderLog->setMessage($logText);
			                $newOrderLog->setModelOrdered($entity);
			                $em->persist($newOrderLog);
			                $em->flush();

						}else{
							// Attention, le FindBy ici renvoi un array.
							$prodLog = $prodLog[0];
							$prodLog->setStatus($valueNum);
							$em->persist($prodLog);
	                		$em->flush();
	                		/******************/
	                		// Log sur le produit
	                		$newOrderLog = new RarOrderLog();
			                $newOrderLog->setDate($time);
			                $newOrderLog->setOrder($order);
			                $newOrderLog->setMessage($logText);
			                $newOrderLog->setModelOrdered($entity);
			                $em->persist($newOrderLog);
			                $em->flush();
						}
					}
					// Si value = 1
					// Générer un bon de commande pdf pour chaque et l'attacher à un email qu'on envoie à la boutique Cc. le manager de Prod et Cc. l'utilisateur qui demande l'action.
					// si value = 2
					$valid = 'All Workrooms have been notified. You rock !';
				}else{
					$error = 'This action does not exist.';
				}
		    	
			}else{
				$error = 'No action is define or no model is selected.';
			}
		}else{
			$error = 'You are trying to hack me and I do not like this.';
		}

		$response = array('valid'=> $valid, 'error' => $error, 'arrayresponse' => $arrayresponse);
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
    	$serializer = new Serializer($normalizers, $encoders);
		return new Response($serializer->serialize($response, 'json'));
		
	}
}