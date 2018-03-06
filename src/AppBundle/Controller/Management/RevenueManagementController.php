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

class RevenueManagementController extends Controller
{
	/**
     *
     * @Route("/{_locale}/management/revenue/{action}/{shop}", name="revenuemanagement")
     *
     * Security("has_role('ROLE_ADMIN') or has_role('ROLE_ACCOUNTING_MANAGER')")
     *
     */
    public function indexAction($action = 'view', $shop = 'all', UserInterface $user, Request $request)
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
        		foreach ($shops as $key => $shop) {

	    			
			        $querySumPerShop = $repositoryRevenue->createQueryBuilder('r')
			            ->select("SUM(r.prixSoldHT) as amount, s.name as shopname, s.extention, MONTH(o.dateMaxShip) AS Omonth, YEAR(o.dateMaxShip) AS Oyear")
			            ->leftJoin('r.order', 'o')
			            ->leftJoin('o.shop', 's')
			            ->where('o.state NOT IN (:status)')
			            ->andWhere('o.dateMaxShip < :date')
			            ->setParameters(['status' => array(0, 1, 4), 'date' => '30/08/2018'])
			            ->groupBy('s.id')
			            ->addGroupBy('Oyear')
			            ->addGroupBy('Omonth');
			        $sumRevenuePerShop = $querySumPerShop->getQuery()->getResult();

		        	// Stock Réel
		        	$revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['IDShop'] = $shop->getId();
		        	$revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['Name'] = $sumRevenuePerShop[$key]['shopname'];
		        	$revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['Period'] = $sumRevenuePerShop[$key]['Oyear'].'-'.$sumRevenuePerShop[$key]['Omonth'];
		        	$revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['Year'] = $sumRevenuePerShop[$key]['Oyear'];
		            $revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['Month'] = $sumRevenuePerShop[$key]['Omonth'];
		            $revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['Amount'] = $sumRevenuePerShop[$key]['amount'];
		            $revenueDisplay[$sumRevenuePerShop[$key]['shopname']][$key]['value'] = $sumRevenuePerShop[$key]['amount'];
		        }

	            return $this->render('management/revenue.html.twig', array(
	                'name' => $name,
	                'locale' => $locale,
	                'title' => ' | Revenue Management',
	                'h1title' => 'Bienvenue User',
	                'p1h2' => $this->get('translator')->trans('Manage the revenue'),
	                'bodyClass' => 'nav-md',
	                'user' => $user,
	                'revenue' => $revenueDisplay,
	                'debug' => $sumRevenuePerShop,
	                'shop' => $shops
	            ));
	        }elseif($action == 'extractRevenuPerMonth.csv'){

	        	if($shop == 'all'){

	        		$dateend = $request->get('dateend');
					$dateend = new \DateTime($dateend);
					$datestart = $request->get('datestart');
					$datestart = new \DateTime($datestart);

					$from = new \DateTime($datestart->format("Y-m-d")." 00:00:00");
    				$to   = new \DateTime($dateend->format("Y-m-d")." 23:59:59");

			        $em = $this->get('doctrine.orm.entity_manager');
			        $dql = "SELECT 
			        	s.extention as Extension, 
			        	s.name as Shop_Name, 
			        	CONCAT(s.extention,o.year,'-',o.idCompta) AS NumOrder , 
			        	DATE(o.dateMaxShip) AS MaxDateShip, 
			        	WEEK(o.dateMaxShip) AS Week, 
			        	YEAR(o.dateMaxShip) AS YEAR, 
			        	SUM(r.prixSoldHT) as Amount
			        	FROM AppBundle:RarModelOrdered r
			        	LEFT JOIN r.order o
			        	LEFT JOIN o.shop s
			        	WHERE o.state NOT IN(0,1,4)
			        	AND (DATE_FORMAT(o.dateMaxShip, '%Y-%m-%d %H:%i') BETWEEN '".$from->format("Y-m-d H:i")."' AND '".$to->format("Y-m-d H:i")."')
			        	GROUP BY NumOrder
			        	";
			        $query = $em->createQuery($dql);
		        	$sumRevenuePerShop = $query->getResult();

		        	$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		        	$file = $serializer->encode($sumRevenuePerShop, 'csv');

		        	$response = new Response($file);
		        	$response->headers->set('Content-Type', 'text/csv');
		        	$response->headers->set('Content-Disposition', 'attachment; filename="export-revenu-all.csv"');

			        return $response;
	        	}else{

			        $dateend = $request->get('dateend');
					$dateend = new \DateTime($dateend);
					$datestart = $request->get('datestart');
					$datestart = new \DateTime($datestart);

					$from = new \DateTime($datestart->format("Y-m-d")." 00:00:00");
    				$to   = new \DateTime($dateend->format("Y-m-d")." 23:59:59");

			        $em = $this->get('doctrine.orm.entity_manager');
			        $dql = "SELECT 
			        	s.extention as Extension, 
			        	s.name as Shop_Name, 
			        	CONCAT(s.extention,o.year,'-',o.idCompta) AS NumOrder , 
			        	DATE(o.dateMaxShip) AS MaxDateShip, 
			        	WEEK(o.dateMaxShip) AS Week, 
			        	YEAR(o.dateMaxShip) AS YEAR, 
			        	SUM(r.prixSoldHT) as Amount
			        	FROM AppBundle:RarModelOrdered r
			        	LEFT JOIN r.order o
			        	LEFT JOIN o.shop s
			        	WHERE o.state NOT IN(0,1,4)
			        	AND (DATE_FORMAT(o.dateMaxShip, '%Y-%m-%d %H:%i') BETWEEN '".$from->format("Y-m-d H:i")."' AND '".$to->format("Y-m-d H:i")."')
			        	AND s.id = '".$shop."'
			        	GROUP BY NumOrder
			        	";
			        $query = $em->createQuery($dql);
		        	$sumRevenuePerShop = $query->getResult();

		        	$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		        	$file = $serializer->encode($sumRevenuePerShop, 'csv');

		        	$response = new Response($file);
		        	$response->headers->set('Content-Type', 'text/csv');
		        	$response->headers->set('Content-Disposition', 'attachment; filename="export-revenu-'.$shop.'.csv"');

			        return $response;
	        	}
	        	
	        	//return $file;
	        	// instantiation, when using it inside the Symfony framework
				//$serializer = $container->get('serializer');

				// encoding contents in CSV format
				//$serializer->encode($sumRevenuePerShop, 'csv');

				// decoding CSV contents
				//$sumRevenuePerShop = $serializer->decode(file_get_contents('data.csv'), 'csv');


	        }else if($action == 'extract'){




	        }else{
	        	return $this->redirect('login');
	        }
        }else{
            return $this->redirect('login');
        }
    }
}