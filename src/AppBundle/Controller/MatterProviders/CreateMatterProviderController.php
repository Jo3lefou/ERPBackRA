<?php

namespace AppBundle\Controller\MatterProviders;

use AppBundle\Entity\RarMatterProvider;
use AppBundle\Form\MatterProviderType;

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

class CreateMatterProviderController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matterproviders/create/", name="creatematterprovider")
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
            
            $newMatterProvider = new RarMatterProvider;
            // Creation du Form basé sur le form ShopType
            $form = $this->createForm(MatterProviderType::class, $newMatterProvider);

            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newMatterProvider = $form->getData();
                // Enregistrement
                $em->persist($newMatterProvider);
                //print_r($newShop);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('creatematterprovider');
            }

            return $this->render('matterproviders/matterprovider/matterprovider.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new matter provider'),
                    'p1h2' => $this->get('translator')->trans('The new matter provider'),
                    'p1h3' => $this->get('translator')->trans('Create here your matter provider'),
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