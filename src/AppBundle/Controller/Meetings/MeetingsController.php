<?php

namespace AppBundle\Controller\Meetings;

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

class MeetingsController extends Controller
{
    /**
     *
     * @Route("/{_locale}/meeting/list/{type}", name="meetinglist")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_SALE_MANAGER') or has_role('ROLE_ACCOUNTING_MANAGER')")
     */
    public function listAction(UserInterface $user, $type = 'cancelet')
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;


        // RETURN
        if($user){
            return $this->render('meeting/list.html.twig', array(
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

    /**
     *
     * @Route("/{_locale}/meeting/report/", name="meetingreport")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_SALE_MANAGER') or has_role('ROLE_ACCOUNTING_MANAGER')")
     */
    public function reportAction(UserInterface $user)
    {
		$user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(User::class);
        $sales = $repository->findBy( array('role'=> array('ROLE_SALE_MANAGER', 'ROLE_SALE')) );

        $em = $this->get('doctrine.orm.entity_manager');

        $report1 = '';
       	foreach ($sales as $key => $sale) {
       		$idSale = $sale->getId();
       		$dql = "SELECT CONCAT(a.firstName, ' ', a.lastName) as Name, a.userColor as Color, a.id as id
                FROM AppBundle:User a
                WHERE a.id = ".$idSale." AND a.state != 2
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['info'] = $query->getResult();


       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['totalMeeting'] = $query->getResult();

	        /* 1er RDV */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 1 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['perRdv'] = $query->getResult();

	        /* 2em RDV */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 2 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['demeRdv'] = $query->getResult();

	        /* 1er Ess */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 3 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['perEssayage'] = $query->getResult();

	        /* 2em Ess */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 4 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['demEssayage'] = $query->getResult();

	        /* PickUp */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 5 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['pickUp'] = $query->getResult();

	        /* Autre */
       		$dql = "SELECT COUNT(a.id) as countTotal, b.id AS idSale
                FROM AppBundle:RarMeeting a
                INNER JOIN a.sale b
                WHERE b.id = ".$idSale." AND a.type = 0 AND a.state != 2
                GROUP BY idSale
            ";
	 		$query = $em->createQuery($dql);
	        $report1[$key]['autre'] = $query->getResult();

	        /* Nombre de jour travaillé */
	        $dql = "SELECT CONCAT(DAY(a.startDate),'-',MONTH(a.startDate),'-',YEAR(a.startDate)) as day, COUNT(a.id) as NumMeeting
	        		FROM AppBundle:RarMeeting a 
	        		INNER JOIN a.sale b 
	        		WHERE b.id = ".$idSale." AND a.type IN(1,2,3,4) AND a.state != 2 GROUP BY day
            ";
            $query = $em->createQuery($dql);
            $itemdata = $query->getResult();
            $report1[$key]['nbJour'] = $itemdata;

            /* Nombre de jour travaillé */
	        $dql = "SELECT 
	        		SUM (TIMESTAMPDIFF(MINUTE, a.startDate, a.endDate)/60.0 -
				    16*(
				        TIMESTAMPDIFF(DAY, a.startDate,a.endDate)-
				        TIMESTAMPDIFF(DAY, a.startDate,a.endDate)
				    ) -
				    16*(
				        TIMESTAMPDIFF(WEEK, a.startDate,a.endDate)-
				        TIMESTAMPDIFF(WEEK, a.startDate,a.endDate)
				    ) ) AS BusinessHours, 'merge' as id
	        		FROM AppBundle:RarMeeting a 
	        		INNER JOIN a.sale b 
	        		WHERE b.id = ".$idSale." AND a.type IN(1,2,3,4) AND a.state != 2 GROUP BY id
            ";
            $query = $em->createQuery($dql);
            $itemdata = $query->getResult();
            $report1[$key]['time'] = $itemdata;
       	}

        // RETURN
        if($user){
            return $this->render('meeting/report.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Report'),
                    'p1h2' => $this->get('translator')->trans('View your reports'),
                    'p1h3' => $this->get('translator')->trans('Real time data'),
                    'p2h2' => $this->get('translator')->trans('Utilisation'),
                    'p2h3' => $this->get('translator')->trans('Get number of meetings'),
                    'p3h2' => $this->get('translator')->trans('Conversion'),
                    'p3h3' => $this->get('translator')->trans('How can you convert visitors'),
                    'title' => ' | '.$this->get('translator')->trans('Repport on meeting'),
                    'h1title' => $this->get('translator')->trans('Calendar'),
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'report1' => $report1
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}