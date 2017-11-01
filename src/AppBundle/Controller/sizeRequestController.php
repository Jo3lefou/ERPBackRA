<?php

namespace AppBundle\Controller;


use AppBundle\Entity\RarModel;
use AppBundle\Entity\RarSize;
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

class sizeRequestController extends Controller
{
	public function indexAction(Request $request)
	{
	    if($request->request->get('val') && $request->request->get('rel')){

	    	$id = $request->request->get('val');
	    	$repository = $this->getDoctrine()->getRepository(RarModel::class);
	    	$model = $repository->find($id);
	    	$sizes = $model->getActiveSizes();

			$encoders = array(new XmlEncoder(), new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());
	    	$serializer = new Serializer($normalizers, $encoders);

			return new Response($serializer->serialize($sizes, 'json'));
	    }

	    return $this->redirect('/homepage/');
	}
}