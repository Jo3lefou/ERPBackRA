<?php

namespace AppBundle\Controller\Stock;

use AppBundle\Entity\RarStockLog;
use AppBundle\Entity\RarWorkroom;
use AppBundle\Form\StockLogType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class CreateStockController extends Controller
{
	/**
     * @Route("/admin/{_locale}/stocks/create/{id}", name="createstocks")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_PRODUCTION_MANAGER')")
     *
     */
    public function indexAction($id, Request $request, MessageGenerator $messageGenerator)
    {

   		$user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $role = $this->getUser()->getRole();
        $customerAllow = $this->getUser()->getCustomerAllow();
        $name = $firstName.' '.$lastName;

        if($user){
    		$em = $this->getDoctrine()->getManager();
    		$matter = $em->getRepository('AppBundle:RarMatter')->findBy(array('isActive' => 1));

            $newStockLog = new RarStockLog();
            for ($i=0; $i < 3; $i++) { 
                // On génère trois line de formulaire
                $ufid = 'from'.$i;
                
                $form = $this->get('form.factory')->createNamed($ufid, StockLogType::class, $newStockLog)
                    ->add('matter', entityType::class,
                       array(
                             'label'=>'Select the matter',
                             'class'=>'AppBundle:RarMatter',
                             'choice_label' => function($matter){
                                return sprintf('%s %s (%s)', $matter->getName(), $matter->getColor(), $matter->getSku());
                             },
                             'required' => true,
                             'choices' => $matter,
                        )
                    );
                $aForm[$ufid] = $form;
                $aFormViews['stockLines'] = $form->createView();

                /*$form = $this->createForm(StockLogType::class, $newStockLog)
                    ->add('matter', entityType::class,
                       array(
                             'label'=>'Select the matter',
                             'class'=>'AppBundle:RarMatter',
                             'choice_label' => function($matter){
                                return sprintf('%s %s (%s)', $matter->getName(), $matter->getColor(), $matter->getSku());
                             },
                             'required' => true,
                             'choices' => $matter,
                        )
                    );*/
            }
    		
    		
		    

		   	return $this->render('stocks/stock/stock.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create new manual stockLines'),
                    'p1h2' => $this->get('translator')->trans('Stocklines'),
                    'p1h3' => $this->get('translator')->trans(''),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('StockLines'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'form' => $aFormViews /*->createView()*/
                )
            );
		}else{
            return $this->redirect('login');
        }

    }
}