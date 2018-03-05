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
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public function formAction(Request $request, $customerid = '', $meetingid = '')
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:RarCustomer')->find($customerid);
        $meeting = $em->getRepository('AppBundle:RarMeeting')->find($meetingid);
        $location = $meeting->getLocation();
        $dresses = $em->getRepository('AppBundle:RarModel')->findBy(array('isForm' => 1, 'isActive' => 1));

        $dql = 'SELECT c FROM AppBundle:RarCustomer c INNER JOIN c.meetings m WHERE m.id = '.$meetingid.' AND c.id = '.$customerid.' AND m.type = 1';
        $query = $em->createQuery($dql);
        $allow = $query->getResult();

        $yes=0;$error='';
        if($allow){
            $yes = 1;
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
                'error' => $error
            )
        );
    }

    /**
     *
     * @Route("/public/{_locale}/meeting/cancel/{meeting}/{customer}", name="meetingcancel")
     *
    */
    public function cancelAction($customer = '', $meeting = '')
    {
        return $this->render('meeting/report.html.twig', array(
                'h1' => $this->get('translator')->trans('Report'),
                'p1h2' => $this->get('translator')->trans('View your reports'),
                'p1h3' => $this->get('translator')->trans('Real time data'),
                'p2h2' => $this->get('translator')->trans('Utilisation'),
                'p2h3' => $this->get('translator')->trans('Get number of meetings'),
                'p3h2' => $this->get('translator')->trans('Conversion'),
                'p3h3' => $this->get('translator')->trans('How can you convert visitors'),
                'title' => ' | '.$this->get('translator')->trans('Repport on meeting'),
                'h1title' => $this->get('translator')->trans('Calendar'),
            )
        );
    }
}