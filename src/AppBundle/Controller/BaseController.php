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

	    // Nb Order Pending
	    $nbOrderPending = $qb->select('COUNT(r)')
	                ->from('AppBundle:RarOrder' , 'r')
	                ->where('r.state = :rstate')
	                ->setParameters(['rstate' => '1'])
	                ->getQuery()
	                ->getOneOrNullResult();

	    // Nb Customer
	    $nbCustomerTotal = $qb->select('COUNT(c)')
	                ->from('AppBundle:RarCustomer' , 'c')
	                ->getQuery()
	                ->getOneOrNullResult();


		// Nb Order to deliver this month
	    $dateAsString = $serializer->normalize( new \DateTime('+ 1 month'), null, array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'));

	    $nbOrderToDeliverThisMonth = $qb->select('COUNT(o)')
	                ->from('AppBundle:RarOrder' , 'o')
	                ->where('o.state NOT IN (:ostatus)')
	                ->andWhere('o.dateMaxShip < :odate')
	                ->setParameters(['ostatus' => array(0, 1, 4, 6), 'odate' => $dateAsString])
	                ->getQuery()
	                ->getOneOrNullResult();

		// My data query
		$stat['sumRevenue'] = $sumRevenue;
		$stat['nbOrderPending'] = $nbOrderPending;
		$stat['nbOrderToDeliverThisMonth'] = $nbOrderToDeliverThisMonth;
		$stat['nbOrderTotal'] = $nbOrderTotal;
		$stat['nbCustomerTotal'] = $nbCustomerTotal;

		// bloc rendered
		return $this->render('bloc/bloc-stat.html.twig', array('stat' => $stat));
	}
}