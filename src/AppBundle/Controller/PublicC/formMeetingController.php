<?php
namespace AppBundle\Controller\PublicC;


use AppBundle\Entity\RarPublicForm;
use AppBundle\Entity\RarMeeting;
use AppBundle\Entity\RarLocation;
use AppBundle\Entity\RarCustomer;
use AppBundle\Entity\User;

use AppBundle\Form\RarPublicFormType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Services\MessageGenerator;

use InvalidArgumentException;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class formMeetingController extends Controller
{
    /**
     *
     * @Route("/public/{_locale}/meeting/form/{meetingid}/{customerid}", name="meetingsubmit")
     *
    */
    public function formAction(Request $request, $customerid = '', $meetingid = '', MessageGenerator $messageGenerator)
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->find($customerid);
        $meeting = $em->getRepository('AppBundle:RarMeeting')->find($meetingid);
        $location = $meeting->getLocation();
        $dresses = $em->getRepository('AppBundle:RarModel')->findBy(array('isForm' => 1, 'isActive' => 1));


        $dql = 'SELECT c FROM AppBundle:RarCustomer c INNER JOIN c.meetings m WHERE m.id = '.$meetingid.' AND c.id = '.$customerid.' AND m.type = 1 AND m.state = 0';
        $query = $em->createQuery($dql);
        $allow = $query->getResult();

        $yes=0;$error='';$already='';
        if($allow){
            $already = $meeting->getPublicForm();
            if($already){
                $error = 'You have already fill in the form...';
            }else{
                $yes = 1;
            }
        }
        if($yes == 0){
            $error = 'You are not allowed to access to that page...';
        }

        // New Order
        $newPublicForm = new RarPublicForm();

        // Creation du Form basé sur le form UserType
        $Publicform = $this->createForm(RarPublicFormType::class, $newPublicForm);
        // Load of the form
        $Publicform->handleRequest($request);
        if ( $Publicform->isSubmitted() ) {
            $time = date_create(date('Y/m/d H:i:s'));
            $message = $messageGenerator->getHappyMessage();
            $newPublicForm = $Publicform->getData();
            // Dress Manual save
            $dresses = $request->get('q4');
            $dressList = serialize($dresses);
            $newPublicForm->setQ4($dressList);
            // Set Meeting
            $newPublicForm->setMeeting($meeting);
            // Set Customer
            $newPublicForm->setCustomer($customer);
            $newPublicForm->setCreationDate($time);
            // Save
            $em->persist($newPublicForm);
            $em->flush();

            $meeting->setPublicForm($newPublicForm);
            $em->persist($meeting);
            $em->flush();

            return $this->redirect('/public/'.$locale.'/meeting/formvalid/'.$meetingid.'/'.$customerid);
        }
        // RETURN
        return $this->render('publicform/form.html.twig', array(
                'h1' => $this->get('translator')->trans('Report'),
                'p1h2' => $this->get('translator')->trans('View your reports'),
                'p1h3' => $this->get('translator')->trans('Real time data'),
                'p2h2' => $this->get('translator')->trans('Utilisation'),
                'p2h3' => $this->get('translator')->trans('Get number of meetings'),
                'p3h2' => $this->get('translator')->trans('Conversion'),
                'p3h3' => $this->get('translator')->trans('How can you convert visitors'),
                'title' => ' | '.$this->get('translator')->trans('Repport on meeting'),
                'h1title' => $this->get('translator')->trans('Calendar'),
                'customer' => $customer,
                'dresses' => $dresses,
                'location' => $location,
                'form' => $Publicform->createView(),
                'error' => $error,
                'already' => $already,
                'meeting' => $meeting,
            )
        );
    }

    /**
     *
     * @Route("/public/{_locale}/meeting/cancel/{meetingid}/{customerid}", name="meetingcancel")
     *
    */
    public function cancelAction(Request $request, $customerid = '', $meetingid = '')
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->find($customerid);
        $meeting = $em->getRepository('AppBundle:RarMeeting')->find($meetingid);
        $location = $meeting->getLocation();

        $dql = 'SELECT c FROM AppBundle:RarCustomer c INNER JOIN c.meetings m WHERE m.id = '.$meetingid.' AND c.id = '.$customerid.' AND m.state = 0';
        $query = $em->createQuery($dql);
        $allow = $query->getResult();

        $yes=0;$error='';$already='';
        if($allow){
            $yes = 1;
        }else{
            $error = 'You are not allowed to access to that page...';
        }

        return $this->render('publicform/cancelation.html.twig', array(
                'locale' => $locale,
                'title' => ' | '.$this->get('translator')->trans('Confirm your cancelation...'),
                'customer' => $customer,
                'meeting' => $meeting,
                'location' => $location,
                'error' => $error,
            )
        );
    }

    /**
     *
     * @Route("/public/{_locale}/meeting/formvalid/{meetingid}/{customerid}", name="formvalid")
     *
    */
    public function formvalidAction(Request $request, $customerid = '', $meetingid = '')
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->find($customerid);
        $meeting = $em->getRepository('AppBundle:RarMeeting')->find($meetingid);
        $location = $meeting->getLocation();

        return $this->render('publicform/valid.html.twig', array(
                'h1' => $this->get('translator')->trans('Report'),
                'p1h2' => $this->get('translator')->trans('View your reports'),
                'p1h3' => $this->get('translator')->trans('Real time data'),
                'p2h2' => $this->get('translator')->trans('Utilisation'),
                'p2h3' => $this->get('translator')->trans('Get number of meetings'),
                'p3h2' => $this->get('translator')->trans('Conversion'),
                'p3h3' => $this->get('translator')->trans('How can you convert visitors'),
                'title' => ' | '.$this->get('translator')->trans('Repport on meeting'),
                'h1title' => $this->get('translator')->trans('Calendar'),
                'customer' => $customer,
                'meeting' => $meeting,
                'location' => $location,
                'error' => '',
                'state' => 'valid'
            )
        );
    }

    /**
     *
     * @Route("/public/{_locale}/meeting/formcancel/{meetingid}/{customerid}", name="formcancel")
     *
    */
    public function formcancelAction(Request $request, $customerid = '', $meetingid = '')
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->find($customerid);
        $meeting = $em->getRepository('AppBundle:RarMeeting')->find($meetingid);
        $location = $meeting->getLocation();
        $sale = $meeting->getSale();

        $dql = 'SELECT c FROM AppBundle:RarCustomer c INNER JOIN c.meetings m WHERE m.id = '.$meetingid.' AND c.id = '.$customerid.' AND m.state = 0';
        $query = $em->createQuery($dql);
        $allow = $query->getResult();

        $yes=0;$error='';$already='';
        if($allow){
            $yes = 1;
            $meeting->setState('2');
            $em->persist($meeting);
            $em->flush();


            $startTime = $meeting->getStartDate();
            $startEmailDate = $startTime->format('d/m/Y');
            $startEmailTime = $startTime->format('H:i');

            $customer = $meeting->getCustomer();
            $dataCusEmail = $customer->getEmail();
            $dataCusLang = $customer->getLocale();
            $configuration = $sale->getConfiguration();
            if($dataCusLang == 'fr'){
                $content = $configuration->getEmailRdvCancelation();
                $subject = 'Rime Arodaky - Annulation de votre rendez-vous';
            }else if($dataCusLang == 'fr'){
                $content = $configuration->getEmailRdvCancelationEn();
                $subject = 'Rime Arodaky - Meeting cancelation';
            }

            

            // SEND A NOTIFICATION TO THE SALE

            $saleEmail = $sale->getEmail();
            $saleLocale = $sale->getLocale();
            // ****** NOTIFICATION EMAIL ******* //
            $message = (new \Swift_Message('RA - Notification : Meeting Canceled.'))
                ->setFrom('notification@rime-arodaky.com')
                ->setTo($saleEmail)
                ->setContentType("text/html")
                ->setBody(
                    $this->renderView( 'email/cancelationMeetingSale.html.twig',
                    array('locale' => $saleLocale, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'date' => $startEmailDate, 'time' => $startEmailTime) )
                );
            $mailer->send($message);
            // ****** NOTIFICATION EMAIL ******* //


            // SEND A CONFIRMATION TO THE CUSTOMER
            

            // ****** NOTIFICATION EMAIL ******* //
            $message = (new \Swift_Message($subject))
                ->setFrom('notification@rime-arodaky.com')
                ->setTo($dataCusEmail)
                ->setContentType("text/html")
                ->setBody(
                    $this->renderView( 'email/cancelationMeeting.html.twig',
                    array('locale' => $dataCusLang, 'meeting' => $meeting, 'customer' => $customer, 'content' => $content, 'date' => $startEmailDate, 'time' => $startEmailTime) )
                );
            $mailer->send($message);
            // ****** NOTIFICATION EMAIL ******* //


        }else{
            $error = 'You are not allowed to access to that page...';
        }

        
        // Change Status of the meeting
        
        return $this->render('publicform/valid.html.twig', array(
                'locale' => $locale,
                'title' => ' | '.$this->get('translator')->trans('Your meeting has been canceled'),
                'customer' => $customer,
                'meeting' => $meeting,
                'location' => $location,
                'error' => '',
                'state' => 'cancel'
            )
        );
    }
}