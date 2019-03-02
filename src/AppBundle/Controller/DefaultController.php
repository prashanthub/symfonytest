<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /*
        // Check User Type
        $auth_checker = $this->get('security.authorization_checker');
        $isRoleUser = $auth_checker->isGranted('ROLE_USER');

        // Get User Details
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();*/


        $auth_checker = $this->get('security.authorization_checker');
        // Redirect to Admin if role is Admin
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_homepage');
        } 

        return $this->redirectToRoute('view_all_posts');
    }

}
