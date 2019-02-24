<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
	public function renderLogin(array $data) {


        $requestRoute = $this->container->get('request_stack')->getCurrentRequest()->get('_route');
        if ($requestRoute == 'admin_login') {
            $template = sprintf('pages/admin/login.html.twig');
        } else {
            $template = sprintf('FOSUserBundle:Security:login.html.twig');
        }
        return $this->container->get('templating')->renderResponse($template, $data);
    }
}

