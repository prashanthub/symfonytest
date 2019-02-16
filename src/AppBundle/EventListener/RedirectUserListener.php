<?php

namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\User;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class RedirectUserListener
{
    private $tokenStorage;
    private $router;

    public function __construct(TokenStorageInterface $t, RouterInterface $r)
    {
        $this->tokenStorage = $t;
        $this->router = $r;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {   
        $currentRoute=$_SERVER['REQUEST_URI'];
        $isLoginRoute=in_array('login',explode('/',$currentRoute));
        $isResetPasswordRoute=in_array('resetting',explode('/',$currentRoute));
        $isRouteCorrect=($isLoginRoute || $isResetPasswordRoute);

        if ($this->isUserLogged()) {
            if($isRouteCorrect){
            $response = new RedirectResponse($this->router->generate('homepage'));
            $event->setResponse($response);
            }
        }else{
            if(!($isRouteCorrect)){
            $response = new RedirectResponse($this->router->generate('fos_user_security_login'));
            $event->setResponse($response);
            }
        }
    }

    private function isUserLogged()
    {   $token = $this->tokenStorage->getToken();
        if(!$token)
        return false;
        $user = $token->getUser();
        return $user instanceof User;
    }

}