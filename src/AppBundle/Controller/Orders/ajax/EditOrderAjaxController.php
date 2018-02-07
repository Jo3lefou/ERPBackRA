<?php

namespace AppBundle\Controller\Orders\ajax;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarStockLog;
use AppBundle\Entity\RarOrderLog;

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

use Psr\Log\LoggerInterface;

class EditOrderAjaxController extends Controller
{

	/**
     * @Route("/{_locale}/orders/update/{type}/{id}", name="updateorder")
     */
	public function indexAction($type, $id, Request $request, \Swift_Mailer $mailer, LoggerInterface $logger)
	{
		if( $request->get('value') || $request->get('value') == 0 ){

            $jsAction = $request->get('action');
			$newValue = $request->get('value');
			$em = $this->getDoctrine()->getManager();
			$time = date_create(date('Y/m/d H:i:s'));
			$dateValidation = "";
            $class = "";
            $lineClass="";
            $error="";
            $idreturn="";

			if($type == 'update-model-ordered'){
            	$entity = $em->getRepository('AppBundle:RarModelOrdered')->find($id);
            	$oldStatus = $entity->getStatus();
            	$entity->setStatus($newValue);
            	$entity->setDateModification($time);
            	switch($newValue){
            		case 0: $class = 'btn btn-default dropdown-toggle btn-xs state st-td'; $stateWord ='to do'; break;
                    case 1: $class = 'btn btn-default dropdown-toggle btn-xs state st-es'; $stateWord ='in stock'; break;
                    case 2: $class = 'btn btn-default dropdown-toggle btn-xs state st-ew'; $stateWord ='sent to workroom'; break;
                    case 3: $class = 'btn btn-default dropdown-toggle btn-xs state st-cut'; $stateWord ='cut'; break;
                    case 4: $class = 'btn btn-default dropdown-toggle btn-xs state st-ecp'; $stateWord ='in production'; break;
                    case 5: $class = 'btn btn-default dropdown-toggle btn-xs state st-epf'; $stateWord ='sent by workroom'; break;
                    case 6: $class = 'btn btn-default dropdown-toggle btn-xs state st-rs'; $stateWord ='received by rime arodaky'; break;
                    case 7: $class = 'btn btn-default dropdown-toggle btn-xs state st-rse'; $stateWord ='received by rime arodaky with error'; break;
                    case 8: $class = 'btn btn-default dropdown-toggle btn-xs state st-cs'; $stateWord ='controled';break;
                    case 9: $class = 'btn btn-default dropdown-toggle btn-xs state st-lc'; $stateWord ='delivered'; break;
                    case 10: $class = 'btn btn-default dropdown-toggle btn-xs state st-lc'; $stateWord ='finished'; break;
            	}
            	$lineClass = "";
            	if($newValue >= 2 && $oldStatus < 2){
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
                if( $newValue == 8){
                    $entity->setDateShipping($time);
                }
                // Set Data
                $order = $entity->getOrder();
                $model = $entity->getModel();
                $modelName = $model->getName();
                // Create Log
                $newOrderLog = new RarOrderLog();
                $newOrderLog->setDate($time);
                $newOrderLog->setMessage('The status of the model "'.$modelName.'"" has been changed to "'.$stateWord.'"');
                $newOrderLog->setOrder($order);
                $newOrderLog->setModelOrdered($entity);

                $em->persist($newOrderLog);
                $em->flush();
			}elseif($type == 'update-order'){
				if( $newValue == 6 || $newValue == 7){
					$entity = $em->getRepository('AppBundle:RarOrder')->find($id);
					// Si Pas encore validé
					$oldState = $entity->getState();
					$dateValidation = $entity->getDateValidation();
					if( $oldState < 2 || $dateValidation == '' ){
						$entity->setDateValidation($time);
						$dateValidation = date_create(date('d/m/Y'));
					}
					if( $newValue == 6 || $newValue == 7 ){
						$entity->setDateShipped($time);
					}
					// Changement d'etat
					$entity->setState($newValue);
					$modelsordered = $entity->getmodelsOrdered();
					foreach ($modelsordered as $key => $modelordered) {
						$modelordered->setStatus(8);
						$modelordered->setDateModification($time);
						$em->persist($modelordered);
                		$em->flush();
					}
				}else{
					$entity = $em->getRepository('AppBundle:RarOrder')->find($id);
					// Si Pas encore validé
					$oldState = $entity->getState();
					$dateValidation = $entity->getDateValidation();
					if( $oldState < 2 || $dateValidation == '' ){
						$entity->setDateValidation($time);
						$dateValidation = date('d/m/Y');
					}
					// Changement d'etat
					$entity->setState($newValue);
				}
				switch($newValue){
					case 0: $class = 'btn btn-default dropdown-toggle btn-xs state st-dft'; $lineClass ='st-dft'; $stateWord ='draft'; $emailstateEn = 'is still in the DRAFT status'; $emailstateFr = 'est toujours en brouillon'; break;
              		case 1: $class = 'btn btn-default dropdown-toggle btn-xs state st-pnd'; $lineClass ='st-pnd'; $stateWord ='pending'; $emailstateEn = 'is now pending, still waiting for approbation'; $emailstateFr = 'est en attente de validation'; break;
             		case 2: $class = 'btn btn-default dropdown-toggle btn-xs state st-vlt'; $lineClass ='st-vlt'; $stateWord ='validated'; $emailstateEn = 'has been validated'; $emailstateFr = 'a bien été validée'; break;
             		case 3: $class = 'btn btn-default dropdown-toggle btn-xs state st-err'; $lineClass ='st-err'; $stateWord ='error'; $emailstateEn = 'is in error, please verify your order'; $emailstateFr = 'est en erreur, merci de vérifier votre commande'; break;
              		case 4: $class = 'btn btn-default dropdown-toggle btn-xs state st-ccl'; $lineClass ='st-ccl'; $stateWord ='canceled'; $emailstateEn = 'has been canceled'; $emailstateFr = 'a été annulée'; break;
              		case 5: $class = 'btn btn-default dropdown-toggle btn-xs state st-ctl'; $lineClass ='st-ctl'; $stateWord ='controled'; $emailstateEn = 'has been controled and should be soon available for shipping'; $emailstateFr = 'a été controlée. Vous devriez bientôt la recevoir'; break;
              		case 6: $class = 'btn btn-default dropdown-toggle btn-xs state st-dlv'; $lineClass ='st-dlv'; $stateWord ='delivered'; $emailstateEn = 'has been sent to you. You should receive it soon'; $emailstateFr = 'a été expédiée. Vous recevrez bientôt votre commande'; break;
              		case 7: $class = 'btn btn-default dropdown-toggle btn-xs state st-sis'; $lineClass ='st-sis'; $stateWord ='stored in stock'; $emailstateEn = 'has been store in the stock, pending for shiping'; $emailstateFr = 'a été placée en stock, dans l\'attente d\'être expédiée'; break;
              	}
                $newOrderLog = new RarOrderLog();
                $newOrderLog->setDate($time);
                $newOrderLog->setMessage('Order status updated to "'.$stateWord.'"');
                $newOrderLog->setOrder($entity);
                $em->persist($newOrderLog);
                $em->flush();

                // Get Info for the email.
                $shop = $entity->getShop();
                $shopEmail = $shop->getEmail();
                $shopLocale = $shop->getLocale();

                
                // ****** NOTIFICATION EMAIL ******* //
                $message = (new \Swift_Message('Rime Arodaky - Notification'))
                    ->setFrom('notification@rime-arodaky.com')
                    ->setTo('joffrey.faroux@gmail.com')//$shopEmail
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView( 'email/confirmationOrder.html.twig',
                        array('locale' => $shopLocale, 'order' => $entity, 'shop' => $shop, 'statusEn' => $emailstateEn, 'statusFr' => $emailstateFr ) )
                    );
                $mailer->send($message);
                // ****** NOTIFICATION EMAIL ******* //


			}elseif($type == 'update-workroom'){
                // On Load les éléments
                $newworkroom = $em->getRepository('AppBundle:RarWorkroom')->find($newValue);
                $entity = $em->getRepository('AppBundle:RarModelOrdered')->find($id);

                $order = $entity->getOrder();
                $model = $entity->getModel();
                $modelName = $model->getName();
                $newworkroomName = $newworkroom->getName();
                $status = $entity->getStatus();

                if($status < 2){

                    // Attribution des nouvaux 
                    $dateValidation = date_create(date('d/m/Y'));
                    $entity->setDateModification($time);
                    $entity->setWorkroom($newworkroom);

                    $newOrderLog = new RarOrderLog();
                    $newOrderLog->setDate($time);
                    $newOrderLog->setMessage('Model '.$modelName.' has been assigned to '.$newworkroomName);
                    $newOrderLog->setOrder($order);
                    $newOrderLog->setWorkroom($newworkroom);
                    $newOrderLog->setModelOrdered($entity);

                    $em->persist($newOrderLog);
                    $em->flush();

                }else{
                    $error = '#0003 - Sorry, this action is not permit due to the current state of that production order.';
                }


                
            }elseif($type == 'addmodel'){

                $newValue = '';
                $jsAction = '';

                $modelid = $request->get('model');
                $model = $em->getRepository('AppBundle:RarModel')->find($modelid);
                $order = $em->getRepository('AppBundle:RarOrder')->find($id);

                $entity =  new RarModelOrdered();
                
                $dateValidation = date_create(date('d/m/Y'));
                $size = $request->get('size');
                $length = $request->get('length');
                $comment = $request->get('comment');
                $status = $request->get('status');
                if($request->get('isCommentInvoice') == 'on'){
                    $isCommentInvoice = '1';
                }else{
                    $isCommentInvoice = '0';
                }
                

                $entity->setModel($model);
                $entity->setHeels($length);
                $entity->setSize($size);
                $entity->setComment($comment);
                $entity->setStatus($status);
                $entity->setOrder($order);
                $entity->setIsCommentInvoice($isCommentInvoice);
                $entity->setDateCreation($dateValidation);

                //$entity->

            }

	    	if($error == ''){
                $em->persist($entity);
                $em->flush();
                $idreturn = $entity->getId();
                $response = array('type' => $type, 'id' => $id, 'class' => $class, 'lineclass' => $lineClass, 'datevalidation' => $dateValidation, 'error' => '', 'newValue' => $newValue, 'action' => $jsAction, 'idreturn' => $idreturn);
            }else{
                $response = array('type' => '', 'id' => '', 'class' => '', 'lineclass' => '', 'datevalidation' => '', 'error' => $error, 'newValue' => '', 'action' => $jsAction);
            }
            $encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($response, 'json'));

		}
	}
}