<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function createAction(Request $request){

        $form = $this->createForm(PostType::class);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $post = $form->getData();
            $post->setCreatedAt(new\DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $post->setUpdatedAt(new\DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

            $doctrine = $this->getDoctrine()->getEntityManager();
            $doctrine->persist($post);
            $doctrine->flush();

            return $this->redirect('/posts');

        }

        return $this->render('posts/create.html.twig', ['form' => $form->createView()]);
        //return new \Symfony\Component\HttpFoundation\Response("Olá");
    }


    /**
     *@Route("/edit/{id}")
     *@return Response
     */
    public function editAction(Post $post, Request $request){

        //$post = $this->getDoctrine()->getRepository("AppBundle:Post")
                //->find($id);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $post = $form->getData();
            $post->setCreatedAt(new\DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $post->setUpdatedAt(new\DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

            $doctrine = $this->getDoctrine()->getEntityManager();
            $doctrine->persist($post);
            $doctrine->flush();

            return $this->redirect('/posts/edit/' . $post->getId());

        }

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
