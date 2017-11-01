<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Services\MessageGenerator;
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




class EditProfileController extends Controller
{
    /**
     * @Route("/{_locale}/profile/edit/", name="editprofile")
     */
    public function indexAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, MessageGenerator $messageGenerator, FileUpload $file_upload)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        if($user){
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($user->getId());
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }
            // On cré un formulaire basé sur l'entité qu'on a recherché.
            $form = $this->createForm(UserType::class, $entity);
            $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid())
            {

                $entity = $form->getData();
                //$imageFile = $editForm->get('imageFile')->getData();
                //$imageFile = $form->get('file')->getData();
                $message = $messageGenerator->getHappyMessage();
                
                // Si il y a un fichier
                $imageFile = $form->get('imageFile')->getData();
                if($imageFile){
                    // On supprime le fichier précédent
                    $path = $this->getParameter('files_directory');
                    $fileToRemove = $entity->getImagePath();
                    if($fileToRemove){
                        unlink( $path.'/'.$fileToRemove );
                    }
                    // On Prend le nom du fichier et on l'encode en nom unique
                    $image = $file_upload->upload($imageFile);
                    $entity->setImagePath($image);
                }

                // Set Password
                $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                $entity->setPassword($password);

                $em->persist($entity);
                $em->flush();
                $this->addFlash( "success", $this->get('translator')->trans($message) );
                return $this->redirect($this->generateUrl('profile'));
                $em->refresh($user); // Add this line
                
            }

            return $this->render('users/profile/editprofile.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'h1' => $this->get('translator')->trans('Modify your profile'),
                'p1h2' => $this->get('translator')->trans('Your profile'),
                'p1h3' => $this->get('translator')->trans('Modify your profile'),
                'p2h2' => $this->get('translator')->trans('Rights and Access'),
                'p2h3' => $this->get('translator')->trans('Choose your rights'),
                'p3h2' => $this->get('translator')->trans('Shop associated'),
                'p3h3' => $this->get('translator')->trans(''),
                'title' => ' | '.$this->get('translator')->trans('Profile'),
                'h1title' => 'Votre profile',
                'bodyClass' => 'nav-md',
                'entity'      => $entity,
                'user' => $user,
                'form'   => $form->createView()
            ));
        }else{
            return $this->redirect('login');
        }
    }
}