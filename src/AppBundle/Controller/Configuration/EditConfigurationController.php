<?php
namespace AppBundle\Controller\Configuration;

use AppBundle\Entity\RarConfiguration;
use AppBundle\Form\RarConfigurationType;
use AppBundle\Services\MessageGenerator;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EditConfigurationController extends Controller
{
	/**
     * @Route("/admin/{_locale}/settings", name="editconfiguration")
     * @Security("has_role('ROLE_ADMIN')")
     */

	public function editConfiguration(Request $request, MessageGenerator $messageGenerator)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $role = $this->getUser()->getRole();
        $configuration = $user->getConfiguration();

        if($user){

        	$form = $this->createForm(RarConfigurationType::class, $configuration);
            $orderCondition = $configuration->getOrderCondition();
            $saleCondition = $configuration->getSaleCondition();
            $orderConditionEn = $configuration->getOrderConditionEn();
            $saleConditionEn = $configuration->getSaleConditionEn();
            $emailRdvOne = $configuration->getEmailRdvOne();
            $emailRdvTwo = $configuration->getEmailRdvTwo();
            $emailRdvConf = $configuration->getEmailRdvConf();
            $emailRdvCancelation = $configuration->getEmailRdvCancelation();
            $emailRdvEdition = $configuration->getEmailRdvEdition();
            $emailRdvOneEn = $configuration->getEmailRdvOneEn();
            $emailRdvTwoEn = $configuration->getEmailRdvTwoEn();
            $emailRdvConfEn = $configuration->getEmailRdvConfEn();
            $emailRdvCancelationEn = $configuration->getEmailRdvCancelationEn();
            $emailRdvEditionEn = $configuration->getEmailRdvEditionEn();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $message = $messageGenerator->getHappyMessage();

                $entity = $form->getData();

                $em->persist($entity);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                $em->refresh($entity);

                return $this->redirectToRoute('editconfiguration');

            }

            return $this->render('configuration/editconfiguration.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Edit configuration'),
                    'p1h2' => $this->get('translator')->trans('The company\'s data'),
                    'p1h3' => $this->get('translator')->trans('Here, edit the user'),
                    'p2h2' => $this->get('translator')->trans('Legal mentions'),
                    'p2h3' => $this->get('translator')->trans('Edit legal mentions on billing'),
                    'p3h2' => $this->get('translator')->trans('Emails'),
                    'p3h3' => $this->get('translator')->trans('Edit triggered emails for customer'),
                    'p4h2' => $this->get('translator')->trans('Workrooms associated'),
                    'p4h3' => $this->get('translator')->trans('Manage the workroom associated to the user'),
                    'title' => ' | '.$this->get('translator')->trans('Configuration'),
                    'h1title' => 'La configuration de votre entreprise',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'form' => $form->createView(),
                    'orderCondition' => $orderCondition,
                    'saleCondition' => $saleCondition,
                    'orderConditionEn' => $orderConditionEn,
                    'saleConditionEn' => $saleConditionEn,
                    'emailRdvOne' => $emailRdvOne,
                    'emailRdvTwo' => $emailRdvTwo,
                    'emailRdvConf' => $emailRdvConf,
                    'emailRdvCancelation' => $emailRdvCancelation,
                    'emailRdvEdition' => $emailRdvEdition,
                    'emailRdvOneEn' => $emailRdvOneEn,
                    'emailRdvTwoEn' => $emailRdvTwoEn,
                    'emailRdvConfEn' => $emailRdvConfEn,
                    'emailRdvCancelationEn' => $emailRdvCancelationEn,
                    'emailRdvEditionEn' => $emailRdvEditionEn,
                )
            );

        }else{
            return $this->redirect('login');
        }

    }
}

