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

        /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {

    $authChecker = $this->container->get('security.authorization_checker');
    $router = $this->container->get('router');


        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }
}

