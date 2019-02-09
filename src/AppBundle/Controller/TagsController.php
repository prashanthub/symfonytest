<?php


namespace AppBundle\Controller;
use AppBundle\Entity\Tags;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class TagsController extends Controller
{
	/**
     * @Route("/tags", name="view_all_tags")
     */
    public function showAllTagsAction(Request $request)
    {   
    	$tags=$this->getDoctrine()->getRepository('AppBundle:Tags')->findAll();
        return $this->render('pages/tags/index.html.twig',['tags'=>$tags]);
    }

    /**
     * @Route("/tag/view/{id}", name="view_tag")
     */
    public function viewTagsAction($id)
    {
        $tagData=$this->getDoctrine()->getRepository('AppBundle:Tags')->find($id);
        return $this->render('pages/tags/view.html.twig',['tagData'=>$tagData]);
    }
}
