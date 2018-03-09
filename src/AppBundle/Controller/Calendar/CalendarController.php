<?php

namespace AppBundle\Controller\Calendar;

use AppBundle\Entity\RarMeeting;
use AppBundle\Entity\RarLocation;
use AppBundle\Entity\User;

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

class CalendarController extends Controller
{
    /**
     *
     * @Route("/{_locale}/calendar/{saleuser}", name="calendar")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_PRODUCTION_MANAGER') or has_role('ROLE_SALE_MANAGER') or has_role('ROLE_SALE') or has_role('ROLE_ACCOUNTING_MANAGER')")
     */
    public function indexAction(UserInterface $user, $saleuser = 'all')
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $meetings = '';

        $repository = $this->getDoctrine()->getRepository(User::class);
        $sales = $repository->findBy( array('role'=> array('ROLE_SALE_MANAGER', 'ROLE_SALE')) );

        $repository = $this->getDoctrine()->getRepository(RarLocation::class);
        $location = $repository->findAll();


        $em = $this->get('doctrine.orm.entity_manager');

        if($saleuser == 'all'){
            $dql = "SELECT 
                a.id AS id,
                a.id AS ref,
                c.id AS cusId,
                CONCAT(c.firstName, ' ', c.lastName, ' - ', a.name) as title,
                CONCAT(c.firstName, ' ', c.lastName) as customername, 
                a.name as title2,
                a.comment, 
                a.type as type,
                CASE 
                    WHEN a.type = 1 THEN 'a'
                    WHEN a.type = 2 THEN 'b'
                    WHEN a.type = 3 THEN 'c'
                    WHEN a.type = 4 THEN 'd'
                    WHEN a.type = 5 THEN 'e'
                    ELSE 'f' AS type2,
                a.notifStatus,
                CONCAT(date(a.startDate), ' ', time(a.startDate)) AS starta,
                CONCAT(date(a.endDate), ' ', time(a.endDate)) AS enda,
                b.id AS sale, 
                CONCAT(b.firstName, ' ', b.lastName) AS namesale,
                b.userColor as color,
                CASE WHEN d.id IS NULL or d.id = '' THEN '0' ELSE d.id AS lieu,
                CASE 
                    WHEN a.type = 1 AND (e.id IS NULL OR e.id = '') THEN 'no'
                    WHEN a.type = 1 AND e.id != '' THEN e.id
                    ELSE 'na' 
                AS formFilled
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                INNER JOIN a.customer c
                INNER JOIN a.location d
                LEFT JOIN a.publicForm e
                WHERE a.state < 2
            ";
        }else{
            $dql = "SELECT 
                a.id AS id,
                a.id AS ref,
                c.id AS cusId,
                CONCAT(b.firstName, ' ', b.lastName, ' - ', a.name) as title, 
                a.name as title2,
                a.comment, 
                a.type as type,
                a.notifStatus,
                CONCAT(date(a.startDate), ' ', time(a.startDate)) AS starta,
                CONCAT(date(a.endDate), ' ', time(a.endDate)) AS enda,
                b.id AS sale, 
                CONCAT(b.firstName, ' ', b.lastName) AS namesale,
                b.userColor as color,
                CASE WHEN d.id IS NULL or d.id = '' THEN '0' ELSE d.id AS lieu,
                CASE WHEN e.id IS NULL or e.id = '' THEN 'no' ELSE e.id AS formFilled
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                INNER JOIN a.customer c
                INNER JOIN a.location d
                LEFT JOIN a.publicForm e
                WHERE a.state < 2 AND b.id = ".$saleuser."
            ";
        }
        
        $query = $em->createQuery($dql);
        $meetings = $query->getResult();

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
                    'title' => ' | '.$this->get('translator')->trans('Calendar'),
                    'h1title' => $this->get('translator')->trans('Calendar'),
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'meetings' => $meetings,
                    'salesmen' => $sales,
                    'locations' => $location,
                    'saleuser' => $saleuser
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}
