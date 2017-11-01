<?php

namespace AppBundle\Controller\Model;

use AppBundle\Entity\RarSize;
use AppBundle\Entity\RarModel;
use AppBundle\Form\ModelType;
use AppBundle\Form\Bloc\SizeType;
use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class CreateModelController extends Controller
{
    /**
     *
     * @Route("/admin/{_locale}/models/create/", name="createModel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, MessageGenerator $messageGenerator)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

			$model = new RarModel();
	        $model->setName('Robe...');

	        // Create One Size For Sample
	        $size = new RarSize();
	        //$model->getSizes()->add($sampleSize);
	        $form = $this->createForm(ModelType::class, $model);
	        /*if ($request->isMethod('POST')) {
	            
	        }*/
	        $form->handleRequest($request);
	        if ($form->isSubmitted() && $form->isValid()) {

	        	
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newModel = $form->getData();
                // Save FK
                foreach ($newModel->getSizes() as $size){
	                $size->setModel($newModel);
	            }
	            foreach ($newModel->getMatterAttributed() as $matter){
                    $matter->setModel($newModel);
                    $matter->setDateCreation(date_create(date('Y/m/d H:i:s')));
                }
                // Enregistrement
                $em->persist($newModel);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('createModel');
            }
	        return $this->render('models/model/model.html.twig', array(
	                'name' => $name,
	                'locale' => $locale,
	                'h1' => $this->get('translator')->trans('Create Model'),
	                'p1h2' => $this->get('translator')->trans('Main date of the model'),
	                'p1h3' => $this->get('translator')->trans('Here, create the model'),
	                'p2h2' => $this->get('translator')->trans('Price'),
	                'p2h3' => $this->get('translator')->trans('Define the price of the model'),
	                'p3h2' => $this->get('translator')->trans('Sizes associated'),
	                'p3h3' => $this->get('translator')->trans('Manage the sizes associated to the model'),
	                'title' => ' | '.$this->get('translator')->trans('Model'),
	                'h1title' => 'Create Model',
	                'bodyClass' => 'nav-md',
	                'user' => $user,
	                'form' => $form->createView()
	            )
	        );
		}else{
			return $this->redirect('login');
		}
    }
}