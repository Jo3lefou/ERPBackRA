<?php

namespace AppBundle\Controller\Toolbox;


use AppBundle\Entity\RarShop;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarWorkroom;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ToolboxController extends Controller
{
    /**
     *
     * @Route("/{_locale}/prodtoolbox/expedition", name="expeditiontracker")
     *
     */
    public function expeditiontrackerAction(UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        $shops = $this->getDoctrine()->getRepository(RarShop::class);
        $resultshops = $shops->findBy(array('isActive' => '1'));


        if($user){
            return $this->render('toolbox/exptracker.html.twig', array(
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
                    'shops' => $resultshops
                )
            );
        }else{
            return $this->redirect('login');
        }
    }

    /**
     *
     * @Route("/{_locale}/prodtoolbox/daysheet", name="daysheet")
     *
     */
    public function daysheetAction(UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;


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
                    'user' => $user
                )
            );
        }else{
            return $this->redirect('login');
        }
    }





}
