<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends Controller
{
    /**
     * @Route("/{_locale}/home/", name="home")
     *
     * Security("has_role('ROLE_ADMIN')")
     * Security("has_role('ROLE_USER')")
     * Security("has_role('ROLE_PROVIDER')")
     * Security("has_role('ROLE_SALE')")
     * Security("has_role('ROLE_SALEMANAGER')")
     * Security("has_role('ROLE_ACCOUNTING')")
     */
    public function indexAction(UserInterface $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $currentUser = $this->getUser();

        if($user){
            return $this->render('home.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => 'Homepage',
                'h1title' => $this->get('translator')->trans('Welcome User'),
                'bodyClass' => 'nav-md',
                'user' => $user, 

            ));
        }else{
            return $this->redirect('login');
        }
    }
}
