<?php

namespace AppBundle\Controller\Calendar;

use AppBundle\Entity\RarMeeting;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;

class CalendarController extends Controller
{
    /**
     *
     * @Route("/{_locale}/calendar/", name="calendar")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_PRODUCTION_MANAGER') or has_role('ROLE_SALE_MANAGER') or has_role('ROLE_SALE') or has_role('ROLE_ACCOUNTING_MANAGER')")
     */
    public function indexAction(UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarMeeting::class);

        if($user){
            return $this->render('calendar/calendar.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new meeting'),
                    'p1h2' => $this->get('translator')->trans('Meeting list'),
                    'p1h3' => $this->get('translator')->trans('Create here your new meeting'),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('Order'),
                    'h1title' => $this->get('translator')->trans('Calendar'),
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}
