<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/{_locale}/profile/{id}", defaults={"id"="null"}, name="profile")
     */
    public function indexAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;


        if($id == "null"){
            $usertoDisplay = $user;
        }else{
            $em = $this->getDoctrine()->getManager();
            $usertoDisplay = $em->getRepository('AppBundle:User')->find($id);
        }

        if($user){
            return $this->render('users/profile/profile.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => 'Homepage',
                'h1title' => $this->get('translator')->trans('Welcome User'),
                'bodyClass' => 'nav-md',
                'user' => $user,
                'usertodisplay' => $usertoDisplay
            ));
        }else{
            return $this->redirect('login');
        }
    }
}