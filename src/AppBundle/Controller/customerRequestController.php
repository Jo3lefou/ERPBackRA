<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RarCustomer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\Query\ResultSetMapping;

class customerRequestController extends Controller
{
	public function indexAction(Request $request)
	{
		if( $request->get('value') ){

			$lastName = $request->get('value');

	    	$repository = $this->getDoctrine()
			    ->getRepository(RarCustomer::class);

			$query = $repository->createQueryBuilder('c')
				->select("c.id as id, CONCAT( CONCAT(c.firstName, ' '),  c.lastName) as label, CONCAT( CONCAT(c.firstName, ' '),  c.lastName) as value")
			    ->where('c.lastName LIKE :lastName')
			    ->setParameter('lastName', '%'.$lastName.'%')
			    ->orderBy('c.lastName', 'DESC')
			    ->getQuery();

			$customer = $query->getResult();

			$encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);
			return new Response($serializer->serialize($customer, 'json'));
		}else{
			return $this->redirect('/login/');
		}
	}
}