<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostController extends Controller
{
	/**
     * @Route("/post", name="view_all_posts")
     */
    public function showAllPostsAction(Request $request)
    {   
    	$posts=$this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        return $this->render('pages/index.html.twig',['posts'=>$posts]);
    }

    
    /**
     * @Route("/create", name="create_post")
     */
    public function createPostAction(Request $request)
    {   
        $post = new Post;
        $form = $this->createFormBuilder()
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Create Post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
            $post->setTitle($title);
            $post->setDescription($description);
            $post->setCategory($category);

            $em=$this->getDoctrine()->getManager();
            // to save
            $em->persist($post);
            $em->flush();

            $this->addFlash('message', 'Post Created Successfully.');
            return $this->redirectToRoute('view_all_posts');
        }
        return $this->render('pages/create.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @Route("/view/{id}", name="view_post")
     */
    public function viewPostAction($id)
    {
        $postData=$this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        return $this->render('pages/view.html.twig',['postData'=>$postData]);
    }

    
    /**
     * @Route("/edit/{id}", name="edit_post")
     */
    public function editPostAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        $form = $this->createFormBuilder($post)
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Update Post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();

            $em=$this->getDoctrine()->getManager();
            
            $post=$em->getRepository('AppBundle:Post')->find($id);
            $post->setTitle($title);
            $post->setDescription($description);
            $post->setCategory($category);
            
            $em->flush();

            $this->addFlash('message', 'Post Updated Successfully.');
            return $this->redirectToRoute('view_all_posts');
        }
        return $this->render('pages/edit.html.twig', ['form'=>$form->createView()]);
    }


    /**
     * @Route("/delete/{id}", name="delete_post")
     */
    public function deletePostAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        // to delete
        $postToRemove=$em->getRepository('AppBundle:Post')->find($id);
        $em->remove($postToRemove);
        $em->flush();
        $this->addFlash('message', 'Post Deleted Successfully.');
        return $this->redirectToRoute('view_all_posts');
    }
}
