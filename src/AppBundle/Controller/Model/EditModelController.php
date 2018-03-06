<?php

namespace AppBundle\Controller\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\RarModel;
use AppBundle\Entity\RarSize;
use AppBundle\Form\ModelType;
use AppBundle\Form\Bloc\SizeType;
use AppBundle\Services\MessageGenerator;
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditModelController extends Controller
{
    /**
     * @Route("/admin/{_locale}/models/edit/{id}", name="editmodel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction($id, Request $request, MessageGenerator $messageGenerator, FileUpload $file_upload)
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RarModel')->find($id);
            $entityName = mb_strtolower($entity->getName());

            // Creation du Form basé sur le form UserType
            $form = $this->createForm(ModelType::class, $entity);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                // On crée un message sympas
                $message = $messageGenerator->getHappyMessage();
                // On load le manager de l'entité
                $em = $this->getDoctrine()->getManager();
                // On récupère les données du formulaire
                $entity = $form->getData();
                // Save FK
                foreach ($entity->getSizes() as $size){
                    $size->setModel($entity);
                }
                foreach ($entity->getMatterAttributed() as $matter){
                    $matter->setModel($entity);
                    $matter->setDateCreation(date_create(date('Y/m/d H:i:s')));
                }


                // UPLOAD IMAGE
                $urlImg = $form->get('imageFile')->getData();
                if($urlImg){
                    // On supprime le fichier précédent
                    $path = $this->getParameter('files_directory');
                    $fileToRemove = $entity->getUrlImg();
                    if($fileToRemove){
                        if(file_exists($path.'/'.$fileToRemove)){
                            unlink( $path.'/'.$fileToRemove );
                        }
                    }
                    // On Prend le nom du fichier et on l'encode en nom unique
                    $image = $file_upload->upload($urlImg);
                    $entity->setUrlImg($image);
                }

                // Enregistrement
                $em->persist($entity);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirectToRoute('models');
            }

            return $this->render('models/model/model.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Modify Model').' '.$entityName,
                    'p1h2' => $this->get('translator')->trans('Main date of the model'),
                    'p1h3' => $this->get('translator')->trans('Here, create the model'),
                    'p2h2' => $this->get('translator')->trans('Price'),
                    'p2h3' => $this->get('translator')->trans('Define the price of the model'),
                    'p3h2' => $this->get('translator')->trans('Sizes associated'),
                    'p3h3' => $this->get('translator')->trans('Manage the sizes associated to the model'),
                    'title' => ' | '.$this->get('translator')->trans('Model'),
                    'h1title' => 'Create Model',
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