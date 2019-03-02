<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends Controller
{
	/**
     * @Route("/admin/home", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        $allUserData=$this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return $this->render('pages/admin/index.html.twig',['allUserData'=>$allUserData]);
    }


    /**
     * @Route("/admin/deleteuser/{id}", name="delete_user")
     */
    public function deleteUserAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        // to delete
        $userToRemove=$em->getRepository('AppBundle:User')->find($id);
        $em->remove($userToRemove);
        $em->flush();

        $this->addFlash('message', 'User Deleted Successfully.');
        return $this->redirectToRoute('admin_homepage');
    }
}
