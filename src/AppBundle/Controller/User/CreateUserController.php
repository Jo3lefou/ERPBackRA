<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use AppBundle\Entity\RarWorkroom;
use AppBundle\Entity\RarShop;
use AppBundle\Form\UserType;
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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CreateUserController extends Controller
{
    /**
     * @Route("/admin/{_locale}/users/create/", name="createprofile")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, FileUpload $file_upload, MessageGenerator $messageGenerator)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;


        if($user){
            $workrooms = $this->getDoctrine()->getRepository(RarWorkroom::class);
            $shops = $this->getDoctrine()->getRepository(RarShop::class);
            $newUser = new User();
            // Creation du Form basé sur le form UserType
            $form = $this->createForm(UserType::class, $newUser)
                ->add('role', ChoiceType::class, array(
                    'choices'  => array(
                        'Admin' => 'ROLE_ADMIN',
                        'User Shop' => 'ROLE_USER',
                        'User Workroom' => 'ROLE_PROVIDER',
                        'Sales Manager' => 'ROLE_SALE_MANAGER',
                        'Sales' => 'ROLE_SALE',
                        'Accounting Manager' => 'ROLE_ACCOUNTING_MANAGER',
                        'Production Manager' => 'ROLE_PRODUCTION_MANAGER'
                    )))
                ->add('shops', EntityType::class, array(
                        // query choices from this entity
                        'class' => 'AppBundle:RarShop',
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                        'choices' => $shops->findBy(array('isActive' => '1')),
                    ))
                ->add('workrooms', EntityType::class, array(
                        // query choices from this entity
                        'class' => 'AppBundle:RarWorkroom',
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                        'choices' => $workrooms->findBy(array('isActive' => '1')),
                    ))
                ->add('customerAllow', CheckboxType::class, [ 'required'   => false ] )
                ->remove('imageFile');

            // On choppe la requête et si Ok, on envoie l'enregistrement
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $newUser = $form->getData();
                // Set Password
                $password = $passwordEncoder->encodePassword($newUser, $newUser->getPassword());
                // On choppe la configuration du client : 
                $configuration = $user->getConfiguration();
                // On tire les données de l'image
                //$imageFile = $form->get('imageFile')->getData();
                // On upload l'image
                //$imageFile = $file_upload->upload($imageFile);
                // Si il y a un fichier
                $newUser = $newUser->setPassword($password);
                $newUser = $newUser->setConfiguration($configuration);
                $em->persist($newUser);
                //print_r($newUser);
                $em->flush();

                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('users');
            }

            return $this->render('users/profile/editprofile.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Create a new user'),
                    'p1h2' => $this->get('translator')->trans('Your new user'),
                    'p1h3' => $this->get('translator')->trans('Create here your new user'),
                    'p2h2' => $this->get('translator')->trans('Rights and Access'),
                    'p2h3' => $this->get('translator')->trans('Choose the access right of your user'),
                    'p3h2' => $this->get('translator')->trans('Shop associated'),
                    'p3h3' => $this->get('translator')->trans('Manage the shop associated to your user'),
                    'p4h2' => $this->get('translator')->trans('Workroom associated'),
                    'p4h3' => $this->get('translator')->trans('Manage the workroom associated to your user'),
                    'title' => ' | '.$this->get('translator')->trans('Profile'),
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