<?php

namespace AppBundle\Controller\Shop;

use AppBundle\Entity\RarShop;
use AppBundle\Form\ShopType;
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
use AppBundle\Services\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateShopController extends Controller
{
    /**
     * @Route("/admin/{_locale}/shops/create/", name="createshop")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, MessageGenerator $messageGenerator)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){
            
            $newShop = new RarShop;
            // Creation du Form basé sur le form ShopType
            $form = $this->createForm(ShopType::class, $newShop);

            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newShop = $form->getData();
                // Enregistrement
                $em->persist($newShop);
                //print_r($newShop);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('createshop');
            }

            return $this->render('shops/shop/shop.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new shop'),
                    'p1h2' => $this->get('translator')->trans('The new shop'),
                    'p1h3' => $this->get('translator')->trans('Create here your new shop'),
                    'p2h2' => $this->get('translator')->trans('Contract'),
                    'p2h3' => $this->get('translator')->trans('Manage contract and VAT'),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('New shop'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'form' => $form->createView(),
                )
            );

        }else{
            return $this->redirect('login');
        }
    }
}