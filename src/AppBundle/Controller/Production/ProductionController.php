<?php

namespace AppBundle\Controller\Production;

use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarWorkroom;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductionController extends Controller
{
    /**
     *
     * @Route("/{_locale}/production/view/{idshop}/{idworkroom}/{status}", name="productions")
     *
     */
    public function indexAction($idshop = 'all', $idworkroom = 'all', $status = 'all', UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $repository = $this->getDoctrine()->getRepository(RarModelOrdered::class);
        $workroom = $this->getUser()->getWorkrooms();
        $shops = $this->getUser()->getShops();

        $shoplist = $this->getUser()->getShops();
        $currentWorkroom = "";
        $condition = "";
        if($status == 'all'){
            $condition .= 'p.status IN (0,1,2,3,4,5,6)';
        }elseif($status == 'draft'){
            $condition .= ' p.status = 0';
        }elseif($status == 'finished'){
            $condition .= ' p.status IN (7,8,9)';
        }elseif($status == 'history'){
            $condition .= ' p.status IN (7,8,9)';
        }
        if($idworkroom != 'all'){
            $condition .= ' AND p.workroom = :workroom';
        }
        if($idshop == 'all'){
            $condition .= ' AND d.isActive = 1';
        }elseif($idshop == 'shops'){
            $condition .= ' AND d.isDirectCustomer = 1 AND d.isActive = 1';
        }else{
            $condition .= ' AND d.id = '.$idshop.' AND d.isActive = 1';
        }
        if($status == 'history'){
            $condition .= ' AND p.dateModification < :date';
        }elseif($status == 'finished'){
            $condition .= ' AND p.dateModification > :date';
        }

        // Filtre sur les boutiques
        $numItems = count($shoplist);
        $i = 0;
        if( $idshop == 'all' || $idshop == 'shops' ){
            if($numItems > 1){
                $condition .= ' AND (';
            }
            foreach ($shoplist as $key => $shop) {
                $condition .= 's.shop = '.$shop->getId();
                if(++$i === $numItems) {
                    $condition .= ')';
                }else{
                    $condition .= ' OR ';
                }
            }
        }
        
        $query = $repository->createQueryBuilder('p')
            ->leftJoin('p.order', 's')
            ->leftJoin('s.shop', 'd')
            ->where($condition)
            ->orderBy('p.dateCreation', 'ASC')
            ->getQuery();

        if($idworkroom != 'all'){
            $wkrRepo = $this->getDoctrine()->getRepository(RarWorkroom::class);
            $currentWorkroom = $wkrRepo->findBy(array('id' => $idworkroom));
            $query->setParameter('workroom', $currentWorkroom);
        }

        if($status == 'history'){
            $query->setParameter('date', new \DateTime('-2 month'));
        }elseif($status == 'finished'){
            $query->setParameter('date', new \DateTime('-2 month'));
        }

        $productions = $query->getResult();
        
        
        //print_r($orders);

        if($user){
            return $this->render('productions/list.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Production'),
                    'p1h2' => $this->get('translator')->trans('Manage your production'),
                    'p1h3' => $this->get('translator')->trans('Create here your new order'),
                    'p2h2' => $this->get('translator')->trans(''),
                    'p2h3' => $this->get('translator')->trans(''),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('Production'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'productions' => $productions,
                    'status' => $status,
                    'shops' => $shops,
                    'workrooms' => $workroom,
                    'idworkroom' => $idworkroom,
                    'idshop' => $idshop,
                    'debug' => $condition,
                    'currentworkroom' => $currentWorkroom,
                    'debug' => $query
                )
            );
        }else{
            return $this->redirect('login');
        }
    }
}
