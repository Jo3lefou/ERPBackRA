<?php

namespace AppBundle\Controller\Matters;

use AppBundle\Entity\RarMatter;
use AppBundle\Form\MatterType;

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

class CreateMatterController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matters/create/", name="creatematter")
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
            
            $newMatter = new RarMatter;
            // Creation du Form basé sur le form ShopType
            $form = $this->createForm(MatterType::class, $newMatter);

            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newMatter = $form->getData();
                // Enregistrement
                $em->persist($newMatter);
                //print_r($newShop);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('creatematter');
            }

            return $this->render('matters/matter/matter.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new matter'),
                    'p1h2' => $this->get('translator')->trans('The new matter'),
                    'p1h3' => $this->get('translator')->trans('Create here your matter'),
                    'p2h2' => $this->get('translator')->trans('Contract'),
                    'p2h3' => $this->get('translator')->trans('Manage contract and VAT'),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('New matter'),
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