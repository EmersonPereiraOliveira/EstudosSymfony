<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



/**
 * @Route("/posts")
 * @package AppBundle\Controller
 */
class PostController extends Controller{

    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction(){

        $posts = $this->getDoctrine()->getRepository("AppBundle:Post")
                ->findAll();

        return $this->render('posts/posts.html.twig', ['posts' => $posts]);
    }


    /**
     *@Route("/create")
     *@return Response
     */
    public function createAction(){

        $form = $this->createForm(PostType::class);
        return $this->render('posts/create.html.twig', ['form' => $form->createView()]);
        //return new \Symfony\Component\HttpFoundation\Response("Olá");
    }


    /**
     * @Route("/post/{slug}")
     * @return Response
     */
    public function singleAction($slug){

        $data = ['slug' => $slug];
        return $this->render('posts/single.html.twig', $data);
    }
}
