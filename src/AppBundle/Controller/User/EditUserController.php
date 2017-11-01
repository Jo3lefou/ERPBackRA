<?php

namespace AppBundle\Controller\User;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use AppBundle\Entity\RarWorkroom;
use AppBundle\Entity\RarShop;
use AppBundle\Form\UserType;
use AppBundle\Services\FileUpload;
use AppBundle\Services\FileRemove;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditUserController extends Controller
{
    

    /**
     * @Route("/admin/{_locale}/users/edit/{id}", name="edituser")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction($id, Request $request, UserPasswordEncoderInterface $passwordEncoder, FileUpload $file_upload)
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;

        if($user){

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($id);
            $entityName = $entity->getLastName();
            $entityFirstName = mb_strtolower($entity->getFirstName());

            $workrooms = $this->getDoctrine()->getRepository(RarWorkroom::class);
            $shops = $this->getDoctrine()->getRepository(RarShop::class);
            // Creation du Form basé sur le form UserType
            $form = $this->createForm(UserType::class, $entity)
                ->remove('password')
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
                ->add('customerAllow', CheckboxType::class, [ 'required'   => false ] );

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entity = $form->getData();

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
                // INFOS
                // get_class_methods($imageFile);
                /* Array ( [0] => __construct [1] => getClientOriginalName [2] => getClientOriginalExtension [3] => getClientMimeType [4] => guessClientExtension [5] => getClientSize [6] => getError [7] => isValid [8] => move [9] => getMaxFilesize [10] => getErrorMessage [11] => guessExtension [12] => getMimeType [13] => getPath [14] => getFilename [15] => getExtension [16] => getBasename [17] => getPathname [18] => getPerms [19] => getInode [20] => getSize [21] => getOwner [22] => getGroup [23] => getATime [24] => getMTime [25] => getCTime [26] => getType [27] => isWritable [28] => isReadable [29] => isExecutable [30] => isFile [31] => isDir [32] => isLink [33] => getLinkTarget [34] => getRealPath [35] => getFileInfo [36] => getPathInfo [37] => openFile [38] => setFileClass [39] => setInfoClass [40] => _bad_state_ex [41] => __toString )*/
                
                // On prépare et on enregistre
                $em->persist($entity);
                $em->flush();
                $this->addFlash("success", $this->get('translator')->trans('Well done! We have updated the user') );
                return $this->redirect('/admin/'.$locale.'/users');
                $em->refresh($entity); // Add this line
            }

            return $this->render('users/profile/editprofile.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'h1' => $this->get('translator')->trans('Edit user').' : '.$entityFirstName.' '.$entityName,
                    'p1h2' => $this->get('translator')->trans('The user\'s data'),
                    'p1h3' => $this->get('translator')->trans('Here, edit the user'),
                    'p2h2' => $this->get('translator')->trans('Rights and Access'),
                    'p2h3' => $this->get('translator')->trans('Choose the access right of your user'),
                    'p3h2' => $this->get('translator')->trans('Shop associated'),
                    'p3h3' => $this->get('translator')->trans('Manage the shop associated to the user'),
                    'p4h2' => $this->get('translator')->trans('Workrooms associated'),
                    'p4h3' => $this->get('translator')->trans('Manage the workroom associated to the user'),
                    'title' => ' | '.$this->get('translator')->trans('Profile'),
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