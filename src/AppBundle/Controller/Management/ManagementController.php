<?php

namespace AppBundle\Controller\Management;

use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\Rarshop;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Security\Core\User\UserInterface;

class ManagementController extends Controller
{
	/**
     *
     * @Route("/{_locale}/management/dashboard/{action}", name="dashboardmanagement")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_ACCOUNTING_MANAGER')")
     *
     */
    public function indexAction($action = 'view', UserInterface $user, Request $request)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        // Set Id Compta
        

    	if($user){
    		if($action == 'view'){

    			$revenueDisplay = array();
    			$repositoryRevenue = $this->getDoctrine()->getRepository(RarModelOrdered::class);
    			$repoShop = $this->getDoctrine()->getRepository(RarShop::class);
        		$shops = $repoShop->findBy( array( 'isActive' => 1 ) );

    			$em = $this->get('doctrine.orm.entity_manager');
	            //$dql = "SELECT a FROM AppBundle:RarCustomer a";
				$dql = "SELECT 
					c.color as color,
					c.name as shop,
					SUM(CASE WHEN WEEK(a.datePaiement) = 35 THEN a.amount ELSE 0 END) as W35,
					SUM(CASE WHEN WEEK(a.datePaiement) = 36 THEN a.amount ELSE 0 END) as W36,
					SUM(CASE WHEN WEEK(a.datePaiement) = 37 THEN a.amount ELSE 0 END) as W37,
					SUM(CASE WHEN WEEK(a.datePaiement) = 38 THEN a.amount ELSE 0 END) as W38,
					SUM(CASE WHEN WEEK(a.datePaiement) = 39 THEN a.amount ELSE 0 END) as W39,
					SUM(CASE WHEN WEEK(a.datePaiement) = 40 THEN a.amount ELSE 0 END) as W40,
					SUM(CASE WHEN WEEK(a.datePaiement) = 41 THEN a.amount ELSE 0 END) as W41,
					SUM(CASE WHEN WEEK(a.datePaiement) = 42 THEN a.amount ELSE 0 END) as W42,
					SUM(CASE WHEN WEEK(a.datePaiement) = 43 THEN a.amount ELSE 0 END) as W43,
					SUM(CASE WHEN WEEK(a.datePaiement) = 44 THEN a.amount ELSE 0 END) as W44,
					SUM(CASE WHEN WEEK(a.datePaiement) = 45 THEN a.amount ELSE 0 END) as W45,
					SUM(CASE WHEN WEEK(a.datePaiement) = 46 THEN a.amount ELSE 0 END) as W46,
					SUM(CASE WHEN WEEK(a.datePaiement) = 47 THEN a.amount ELSE 0 END) as W47,
					SUM(CASE WHEN WEEK(a.datePaiement) = 48 THEN a.amount ELSE 0 END) as W48,
					SUM(CASE WHEN WEEK(a.datePaiement) = 49 THEN a.amount ELSE 0 END) as W49,
					SUM(CASE WHEN WEEK(a.datePaiement) = 50 THEN a.amount ELSE 0 END) as W50,
					SUM(CASE WHEN WEEK(a.datePaiement) = 51 THEN a.amount ELSE 0 END) as W51,
					SUM(CASE WHEN WEEK(a.datePaiement) = 52 THEN a.amount ELSE 0 END) as W52,
					SUM(CASE WHEN WEEK(a.datePaiement) = 53 THEN a.amount ELSE 0 END) as W53,
					SUM(CASE WHEN WEEK(a.datePaiement) = 54 THEN a.amount ELSE 0 END) as W54,
					SUM(CASE WHEN WEEK(a.datePaiement) = 01 THEN a.amount ELSE 0 END) as W01,
					SUM(CASE WHEN WEEK(a.datePaiement) = 02 THEN a.amount ELSE 0 END) as W02,
					SUM(CASE WHEN WEEK(a.datePaiement) = 03 THEN a.amount ELSE 0 END) as W03,
					SUM(CASE WHEN WEEK(a.datePaiement) = 04 THEN a.amount ELSE 0 END) as W04,
					SUM(CASE WHEN WEEK(a.datePaiement) = 05 THEN a.amount ELSE 0 END) as W05,
					SUM(CASE WHEN WEEK(a.datePaiement) = 06 THEN a.amount ELSE 0 END) as W06,
					SUM(CASE WHEN WEEK(a.datePaiement) = 07 THEN a.amount ELSE 0 END) as W07,
					SUM(CASE WHEN WEEK(a.datePaiement) = 08 THEN a.amount ELSE 0 END) as W08,
					SUM(CASE WHEN WEEK(a.datePaiement) = 09 THEN a.amount ELSE 0 END) as W09,
					SUM(CASE WHEN WEEK(a.datePaiement) = 10 THEN a.amount ELSE 0 END) as W10,
					SUM(CASE WHEN WEEK(a.datePaiement) = 11 THEN a.amount ELSE 0 END) as W11,
					SUM(CASE WHEN WEEK(a.datePaiement) = 12 THEN a.amount ELSE 0 END) as W12,
					SUM(CASE WHEN WEEK(a.datePaiement) = 13 THEN a.amount ELSE 0 END) as W13,
					SUM(CASE WHEN WEEK(a.datePaiement) = 14 THEN a.amount ELSE 0 END) as W14,
					SUM(CASE WHEN WEEK(a.datePaiement) = 15 THEN a.amount ELSE 0 END) as W15,
					SUM(CASE WHEN WEEK(a.datePaiement) = 16 THEN a.amount ELSE 0 END) as W16,
					SUM(CASE WHEN WEEK(a.datePaiement) = 17 THEN a.amount ELSE 0 END) as W17,
					SUM(CASE WHEN WEEK(a.datePaiement) = 18 THEN a.amount ELSE 0 END) as W18,
					SUM(CASE WHEN WEEK(a.datePaiement) = 19 THEN a.amount ELSE 0 END) as W19,
					SUM(CASE WHEN WEEK(a.datePaiement) = 20 THEN a.amount ELSE 0 END) as W20,
					SUM(CASE WHEN WEEK(a.datePaiement) = 21 THEN a.amount ELSE 0 END) as W21,
					SUM(CASE WHEN WEEK(a.datePaiement) = 22 THEN a.amount ELSE 0 END) as W22,
					SUM(CASE WHEN WEEK(a.datePaiement) = 23 THEN a.amount ELSE 0 END) as W23,
					SUM(CASE WHEN WEEK(a.datePaiement) = 24 THEN a.amount ELSE 0 END) as W24,
					SUM(CASE WHEN WEEK(a.datePaiement) = 25 THEN a.amount ELSE 0 END) as W25,
					SUM(CASE WHEN WEEK(a.datePaiement) = 26 THEN a.amount ELSE 0 END) as W26,
					SUM(CASE WHEN WEEK(a.datePaiement) = 27 THEN a.amount ELSE 0 END) as W27,
					SUM(CASE WHEN WEEK(a.datePaiement) = 28 THEN a.amount ELSE 0 END) as W28,
					SUM(CASE WHEN WEEK(a.datePaiement) = 29 THEN a.amount ELSE 0 END) as W29,
					SUM(CASE WHEN WEEK(a.datePaiement) = 31 THEN a.amount ELSE 0 END) as W30,
					SUM(CASE WHEN WEEK(a.datePaiement) = 31 THEN a.amount ELSE 0 END) as W31,
					SUM(CASE WHEN WEEK(a.datePaiement) = 32 THEN a.amount ELSE 0 END) as W32,
					SUM(CASE WHEN WEEK(a.datePaiement) = 33 THEN a.amount ELSE 0 END) as W33,
					SUM(CASE WHEN WEEK(a.datePaiement) = 34 THEN a.amount ELSE 0 END) as W34
					FROM AppBundle:RarPayment a
					INNER JOIN a.order b
					INNER JOIN b.shop c 
					WHERE b.state NOT IN (0,1,4) AND b.year = SUBSTRING( YEAR( NOW()), 3, 2 )
					AND (
						( MONTH(a.datePaiement) >= '9' AND SUBSTRING( YEAR(a.datePaiement), 3, 2 ) = SUBSTRING( YEAR( NOW() ), 3, 2 )-1 )
						OR ( MONTH(a.datePaiement) < '9' AND SUBSTRING( YEAR(a.datePaiement), 3, 2 ) = SUBSTRING( YEAR( NOW() ), 3, 2 ) )
					)
					GROUP BY shop";
		        	$query = $em->createQuery($dql);
		        	$result = $query->getResult();


	            return $this->render('management/dashboard.html.twig', array(
	                'name' => $name,
	                'locale' => $locale,
	                'title' => ' | Revenue Management',
	                'h1title' => 'Bienvenue User',
	                'p1h2' => $this->get('translator')->trans('Manage the revenue'),
	                'p2h2' => $this->get('translator')->trans('Extract orders'),
	                'bodyClass' => 'nav-md',
	                'user' => $user,
	                'dashboard' => $result,
	                'shops' => $shops,
	            ));
	        }elseif($action == 'extractManagementDashboard.csv'){
	        	// Extract in file dashboard.csv

	        }elseif($action == 'extractorders.csv'){
				// Extract orders
				$status = $request->get('status');
				$shops = $request->get('shops');
				$dateend = $request->get('dateend');
				$dateend = new \DateTime($dateend);
				$datestart = $request->get('datestart');
				$datestart = new \DateTime($datestart);

				$from = new \DateTime($datestart->format("Y-m-d")." 00:00:00");
    			$to   = new \DateTime($dateend->format("Y-m-d")." 23:59:59");

				$type = $request->get('type');

				/*$em = $this->getDoctrine()->getManager();
				$query = $em->createQueryBuilder()
			        ->select("a.id AS DBid,
						CONCAT('#',c.extention,a.year,'-',a.idCompta) AS id,
						CASE WHEN b.firstName != '' THEN CONCAT(b.firstName,' ',b.lastName) ELSE a.customerName END AS customerName,
						a.type AS orderType,
						c.name AS shopName,
						c.country AS countryShop,
						SUM(x.prixSoldHT) AS priceHT,
						DATE_FORMAT(a.dateCivil, '%Y %m %d') AS weddingDate,
						DATE_FORMAT(a.dateOrder, '%Y %m %d') AS orderDate,
						DATE_FORMAT(a.dateValidation, '%Y %m %d') AS validationDate,
						DATE_FORMAT(a.dateMinShip, '%Y %m %d') AS minShippingDate,
						DATE_FORMAT(a.dateMaxShip, '%Y %m %d') AS maxShippingDate,
						DATE_FORMAT(a.dateShipped, '%Y %m %d') AS shippingDate,
						a.state AS status,
						CONCAT(d.firstName,' ',d.lastName) AS creatorName")
			        ->from('AppBundle:RarModelOrdered', 'x')
			        ->innerJoin('x.order', 'a')
			        ->leftJoin('a.customer', 'b')
			        ->innerJoin('a.shop', 'c')
			        ->innerJoin('a.user', 'd')
			        
			        ->where('a.state IN(:state)')
			        ->andwhere('c.id IN(:shops)')
			        ->andwhere('a.type IN(:type)')
			        
			        ->setParameter('state', implode(",",$status))
			        ->setParameter('shops', implode(",",$shops))
			        ->setParameter('type', implode(",",$type))
			        ->getQuery()
			    ;
			    $result = $query->getResult();*/


				/*
				->where('a.dateOrder BETWEEN :from AND :to')
				->setParameter('from', $from)
			        ->setParameter('to', $to)
			        AND a.dateOrder BETWEEN ".$from->format("Y-m-d H:i")." AND ".$to->format("Y-m-d H:i").")

	*/
				$dql = "SELECT
					a.id AS DBid,
					CONCAT('#',c.extention,a.year,'-',a.idCompta) AS id,
					CASE WHEN b.firstName != '' THEN CONCAT(b.firstName,' ',b.lastName) ELSE a.customerName END AS customerName,
					a.type AS orderType,
					c.name AS shopName,
					c.country AS countryShop,
					SUM(x.prixSoldHT) AS priceHT,
					DATE_FORMAT(a.dateCivil, '%Y/%m/%d') AS weddingDate,
					DATE_FORMAT(a.dateOrder, '%Y/%m/%d') AS orderDate,
					DATE_FORMAT(a.dateValidation, '%Y/%m/%d') AS validationDate,
					DATE_FORMAT(a.dateMinShip, '%Y/%m/%d') AS minShippingDate,
					DATE_FORMAT(a.dateMaxShip, '%Y/%m/%d') AS maxShippingDate,
					DATE_FORMAT(a.dateShipped, '%Y/%m/%d') AS shippingDate,
					a.state AS status,
					CONCAT(d.firstName,' ',d.lastName) AS creatorName
					FROM AppBundle:RarModelOrdered x
					INNER JOIN x.order a
					LEFT JOIN a.customer b
					INNER JOIN a.shop c
					INNER JOIN a.user d
					WHERE a.state IN(".implode(",",$status).")
					AND c.id IN(".implode(",",$shops).")
					AND a.type IN(".implode(",",$type).")
					AND DATE_FORMAT(a.dateOrder, '%Y-%m-%d') BETWEEN ".$from->format("Y-m-d")." AND ".$to->format("Y-m-d").")
					GROUP BY DBid";
					
					
					
					
					

				$em = $this->get('doctrine.orm.entity_manager');
				$query = $em->createQuery($dql);
		        $result = $query->getResult();


	        	$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
	        	$file = $serializer->encode($result, 'csv');
	        	$response = new Response($file);
	        	$response->headers->set('Content-Type', 'text/csv');
	        	/*return new Response(
		            '<html><body>'.$dql.'</body></html>'
		        );*/
		        return $response;
	       		
	        }else{
	        	return $this->redirect('login');
	        }
        }else{
            return $this->redirect('login');
        }
    }
}