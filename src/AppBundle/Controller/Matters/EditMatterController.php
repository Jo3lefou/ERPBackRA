<?php

namespace AppBundle\Controller\Matters;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\RarMatter;
use AppBundle\Form\MatterType;


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
use Doctrine\DBAL\Event\Listeners\MysqlSessionInit;

class EditMatterController extends Controller
{
    /**
     * @Route("/admin/{_locale}/matters/edit/{id}", name="editmatter")
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
            $entity = $em->getRepository('AppBundle:RarMatter')->find($id);

            $entityName = mb_strtolower($entity->getName());
            // Creation du Form basé sur le form UserType
            $form = $this->createForm(MatterType::class, $entity);

            $form->handleRequest($request);

            if ( $form->isSubmitted() && $form->isValid() ) {
  
                $entity = $form->getData();
                // On prépare et on enregistre
                $em->persist($entity);
                $em->flush();
                $this->addFlash("success", $this->get('translator')->trans('Well done! We have updated the user') );
                
                $em->refresh($entity); // Add this line
                return $this->redirect('/admin/'.$locale.'/matters/edit/'.$id);
            }

            return $this->render('matters/matter/matter.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Modify the matter').' '.$entityName,
                    'p1h2' => $this->get('translator')->trans('The matter').' '.$entityName,
                    'p1h3' => $this->get('translator')->trans('Modify here your matter'),
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