<?php
namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login-sm")
     * @Route("/login/", name="login")
     */
	public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {

    	//////////////////////////////////////
    	//	  Generer le check si post ?	//
    	//////////////////////////////////////

    	//////////////////////////////////////
    	//	  Afficher la page ou l'erreur	//
    	//////////////////////////////////////
    	// get the login error if there is one
	    $error = $authUtils->getLastAuthenticationError();
	    // last username entered by the user
	    $lastUsername = $authUtils->getLastUsername();
	    //var_dump($request);

	    //////////////////////////////////////////
    	//	  Retourner le content dans login	//
    	//////////////////////////////////////////
	    return $this->render('security/login.html.twig', array(
	    	'title' => 'Connection',
	        'last_username' => $lastUsername,
	        'error'         => $error,
	        'bodyClass' => 'login'
	    ));
    }
	
}