<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryController extends Controller
{
	/**
     * @Route("/category", name="view_all_categories")
     */
    public function showAllCategoryAction(Request $request)
    {   
    	$categories=$this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('pages/category/index.html.twig',['categories'=>$categories]);
    }

    /**
     * @Route("/category/view/{id}", name="view_category")
     */
    public function viewPostAction($id)
    {
        $categoryData=$this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        return $this->render('pages/category/view.html.twig',['categoryData'=>$categoryData]);
    }

    /**
     * @Route("/category/delete/{id}", name="delete_category")
     */
    public function deletePostAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        // to delete
        $categoryToRemove=$em->getRepository('AppBundle:Category')->find($id);
        $em->remove($categoryToRemove);
        $em->flush();

        $this->addFlash('message', 'Category Deleted Successfully.');
        return $this->redirectToRoute('view_all_categories');
    }
}
