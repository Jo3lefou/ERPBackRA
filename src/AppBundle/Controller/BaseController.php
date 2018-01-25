<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarOrder;

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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class BaseController extends Controller
{
	public function getStatDataAction(){
		// Serializer for date 
		$serializer = new Serializer(array(new DateTimeNormalizer()));

		// Total Revenue
		$dateYear = $serializer->normalize( new \DateTime(), null, array(DateTimeNormalizer::FORMAT_KEY => 'y'));

		$repositoryRevenue = $this->getDoctrine()->getRepository(RarModelOrdered::class);
		$querySumPerShop = $repositoryRevenue->createQueryBuilder('r')
            ->select("SUM(r.prixSoldHT) as amount")
            ->leftJoin('r.order', 'o')
            ->leftJoin('o.shop', 's')
            ->where('o.state NOT IN (:status)')
            ->andWhere('s.isActive = 1')
            ->andWhere('o.year = '.$dateYear)
            ->setParameters(['status' => array(0, 1, 4)]);
        $sumRevenue = $querySumPerShop->getQuery()->getResult();

        $em = $this->getDoctrine()->getManager();
	    $qb = $em->createQueryBuilder();

	    // Nb Total Order
	    $nbOrderTotal = $qb->select('COUNT(p)')
	                ->from('AppBundle:RarOrder' , 'p')
	                ->where('p.state NOT IN (:pstate)')
	                ->setParameters(['pstate' => array(0, 1, 4)])
	                ->getQuery()
	                ->getOneOrNullResult();

	    $em2 = $this->getDoctrine()->getManager();
	    $qb2 = $em2->createQueryBuilder();
	    // Nb Order Pending
	    $nbOrderPending = $qb2->select('COUNT(r)')
	                ->from('AppBundle:RarOrder' , 'r')
	                ->where('r.state = :rstate')
	                ->setParameters(['rstate' => '1'])
	                ->getQuery()
	                ->getOneOrNullResult();

	    $em3 = $this->getDoctrine()->getManager();
	    $qb3 = $em3->createQueryBuilder();
	    // Nb Customer
	    $nbCustomerTotal = $qb3->select('COUNT(c)')
	                ->from('AppBundle:RarCustomer' , 'c')
	                ->getQuery()
	                ->getOneOrNullResult();

	    $em4 = $this->getDoctrine()->getManager();
	    $qb4 = $em4->createQueryBuilder();
		// Nb Order to deliver this month
	    $dateAsString = $serializer->normalize( new \DateTime('+ 1 month'), null, array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'));

	    $nbOrderToDeliverThisMonth = $qb4->select('COUNT(o)')
	                ->from('AppBundle:RarOrder' , 'o')
	                ->where('o.state NOT IN (:ostatus)')
	                ->andWhere('o.dateMaxShip < :odate')
	                ->setParameters(['ostatus' => array(0, 1, 4, 6), 'odate' => $dateAsString])
	                ->getQuery()
	                ->getOneOrNullResult();

	    // Best Shops Query
        $repositoryBestShops = $this->getDoctrine()->getRepository(RarModelOrdered::class);
		$queryBestShops = $repositoryRevenue->createQueryBuilder('r')
            ->select("SUM(r.prixSoldHT) as Total, s.name")
            ->leftJoin('r.order', 'o')
            ->leftJoin('o.shop', 's')
            ->where('o.state NOT IN (:status)')
            ->andWhere('s.isActive = 1')
            ->andWhere('o.year = '.$dateYear)
            ->andWhere('s.isDirectCustomer = 0')
            ->setParameters(['status' => array(0, 1, 4)])
            ->groupBy('s.id')
            ->orderBy('Total', 'DESC');
        $sumBestShops = $queryBestShops->getQuery()->getResult();

		// My data query
		$stat['sumRevenue'] = $sumRevenue;
		$stat['nbOrderPending'] = $nbOrderPending;
		$stat['nbOrderToDeliverThisMonth'] = $nbOrderToDeliverThisMonth;
		$stat['nbOrderTotal'] = $nbOrderTotal;
		$stat['nbCustomerTotal'] = $nbCustomerTotal;
		$stat['sumBestShops']= $sumBestShops;

		// bloc rendered
		return $this->render('bloc/bloc-stat.html.twig', array('stat' => $stat));
	}
}