<?php

namespace AppBundle\Controller\MatterProviders;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\RarMatterProvider;
use AppBundle\Form\MatterProviderType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EditMatterProviderController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matterproviders/edit/{id}", name="editmatterprovider")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction($id, Request $request)
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RarMatterProvider')->find($id);

            $entityName = mb_strtolower($entity->getName());
            // Creation du Form basé sur le form UserType
            $form = $this->createForm(MatterProviderType::class, $entity);

            $form->handleRequest($request);
            // remove actual Users form that Shop
            /*if ($form->isSubmitted() && $form->isValid()){
                $what = $em->getRepository('AppBundle:RarShop')->find($id);
                $entityUser = $what->getUsers();
                foreach ($entityUser as $user){

                    $user->removeShop($what);
                    $em->persist($user);
                    $em->flush();
                }
                $entityUser2 = $what->getUsers();
            }*/
            if ( $form->isSubmitted() && $form->isValid() ) {
  
                $entity = $form->getData();
                // Set Shop
                /*$entityUser3 = $entity->getUsers();
                foreach ( $entityUser3 as $user){
                    $user->addShop($entity);
                    $em->flush();
                }*/
                // On prépare et on enregistre
                $em->persist($entity);
                $em->flush();
                $this->addFlash("success", $this->get('translator')->trans('Well done! We have updated the user') );
                
                $em->refresh($entity); // Add this line
                return $this->redirect('/admin/'.$locale.'/matterproviders/edit/'.$id);
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