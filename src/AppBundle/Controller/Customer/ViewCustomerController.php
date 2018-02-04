<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\RarCustomer;
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

class ViewCustomerController extends Controller
{
    /**
     * @Route("/{_locale}/customers/single/view/{id}", name="viewcustomer")
     */
    public function indexAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('AppBundle:RarCustomer')->findOneBy(['id' => $id]);

            return $this->render('customers/customer/customer.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => 'Homepage',
                'h1title' => $this->get('translator')->trans('Welcome User'),
                'bodyClass' => 'nav-md',
                'user' => $user,
                'customer' => $customer,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}