<?php

namespace AppBundle\Controller\Workroom;

use AppBundle\Entity\RarWorkroom;
use AppBundle\Form\RarWorkroomType;

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

class CreateWorkroomController extends Controller
{
    /**
     * @Route("/admin/{_locale}/workrooms/create/", name="createworkroom")
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
            
            $newWorkroom = new RarWorkroom;
            // Creation du Form basé sur le form ShopType
            $form = $this->createForm(RarWorkroomType::class, $newWorkroom);

            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newWorkroom = $form->getData();
                // Set Workroom
                $newWorkroomUser = $newWorkroom->getUsers();
                foreach ( $newWorkroomUser as $user){
                    $user->addWorkroom($newWorkroom);
                    $em->flush();
                }
                // Enregistrement
                $em->persist($newWorkroom);
                //print_r($newShop);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );

                return $this->redirectToRoute('workrooms');
            }

            return $this->render('workrooms/workroom/workroom.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new workroom'),
                    'p1h2' => $this->get('translator')->trans('The new workroom'),
                    'p1h3' => $this->get('translator')->trans('Create here your new workroom'),
                    'p2h2' => $this->get('translator')->trans('Activation'),
                    'p2h3' => $this->get('translator')->trans('Would you like to activate this workroom ?'),
                    'p3h2' => $this->get('translator')->trans(''),
                    'p3h3' => $this->get('translator')->trans(''),
                    'title' => ' | '.$this->get('translator')->trans('New workroom'),
                    'h1title' => 'Votre profile',
                    'bodyClass' => 'nav-md',
                    'user' => $user,
                    'form' => $form->createView()
                )
            );

        }else{
            return $this->redirect('login');
        }
    }
}