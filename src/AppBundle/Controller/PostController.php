<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostController extends Controller
{
	/**
     * @Route("/post", name="view_all_posts")
     */
    public function showAllPostsAction(Request $request)
    {   $user = $this->get('security.token_storage')->getToken()->getUser();
        // Get posts according to the user
        $userFullObject=$this->getDoctrine()->getRepository('AppBundle:User')->find($user->getId());
        return $this->render('pages/index.html.twig',['posts'=>$userFullObject->getPosts()]);
    }

    
    /**
     * @Route("/create", name="create_post")
     */
    public function createPostAction(Request $request)
    {   
        $post = new Post;
        $form = $this->createFormBuilder($post)
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        // add category select option
        ->add('category', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Category',
        'choice_label' => 'name'
        ))
         ->add('tags', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Tags',
        'multiple'=>true,
        'choice_label' => 'name'
        ))
        ->add('image', FileType::class, array('label' => 'Upload File (Image file)',  'required' => false, 'attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Create Post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            // image upload start
            $file = $post->getImage();
            $post->setImage("");
            if($file){
            $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
            $file->move($this->getParameter('photos_directory'), $fileName); 
            $post->setImage($fileName);
            }
            // image upload end
          
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
        ->add('category', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Category',
        'choice_label' => 'name'
        ))
        ->add('tags', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Tags',
        'multiple'=>true,
        'choice_label' => 'name'
        ))
        ->add('save',SubmitType::class,array('label'=>'Update Post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /* <<< Not Required */
            //$title=$form['title']->getData();
            //$description=$form['description']->getData();
            //$category=$form['category']->getData();
            /* Not Required >>> */
            $em=$this->getDoctrine()->getManager();
            
            //$post=$em->getRepository('AppBundle:Post')->find($id);
            /* <<< Not Required */
            //$post->setTitle($title);
            //$post->setDescription($description);
            //$post->setCategory($category);
            /* Not Required >>>*/
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

    
    /**
     * @Route("/addCommentToPost/{id}", name="add_comment_to_post")
     */
    public function addCommentToPostAction(Request $request, $id)
    {   
        $post=$this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        $comments = new Comments;
        $form = $this->createFormBuilder($comments)
        ->add('comment',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Add Comment','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        
        if($form->isValid() && $form->isSubmitted()){
            $comment=$form['comment']->getData();
            $comments->setComment($comment);
            $comments->setCommentPost($post);
            $em=$this->getDoctrine()->getManager();
            // to save
            $em->persist($comments);
            $em->flush();

            $this->addFlash('message', 'Comment Added Successfully.');
            return $this->redirectToRoute('view_all_posts');
        }
        return $this->render('pages/addcomment.html.twig',['form'=>$form->createView(), 'post'=>$post]);
        
    }

    
    /**
     * @Route("/search", name="search_post")
     */
    public function searchPostAction(Request $request){  
        
        $post = new Post;
        $form = $this->createFormBuilder($post)
        ->add('title',TextType::class,array('attr'=>array('class'=>'form-control'), 'required' => false))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control'), 'required' => false))
        // add category select option
        ->add('category', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Category',
        'choice_label' => 'name'
        ))
         ->add('tags', EntityType::class, array(
        'attr'=>array('class'=>'form-control'),
        'class' => 'AppBundle:Tags',
        'multiple'=>true,
        'choice_label' => 'name'
        ))
        ->add('save',SubmitType::class,array('label'=>'Search Post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px;')))
        ->getForm();
        $form->handleRequest($request);
        $posts=$this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        
        if($form->isSubmitted() && $form->isValid()){
            $posts=$this->getDoctrine()->getRepository('AppBundle:Post')->searchPost($post);
            /*$em=$this->getDoctrine()->getManager();
            // to save
            $em->persist($post);
            $em->flush();

            $this->addFlash('message', 'Post Created Successfully.');
            return $this->redirectToRoute('view_all_posts');*/
        }
        return $this->render('pages/search.html.twig',['form'=>$form->createView(), 'posts'=>$posts]);
    }


    /** 
       * @Route("/getuser_ajax", name="get_post_user")
    */ 
    public function ajaxAction(Request $request) { 
       $id=$request->get('postid');
       $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);  
          
       if ($request->isXmlHttpRequest()) {  
          $jsonData = array();    
           
             $temp = array(
                'name' => $post->getUser()->getUsername()   
             );   
             $jsonData[] = $temp;  
         
          return new JsonResponse($jsonData); 
       }
    } 
}
