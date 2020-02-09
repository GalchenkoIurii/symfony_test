<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NotesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $note = new Notes();
        $form = $this->createForm(NotesType::class, $note);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em->persist($note);
            $em->flush();
        }

        $notes = $em->getRepository(Notes::class)->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form'            => $form->createView()
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        $posts = ['first string', 'second string', 'third string'];

        return $this->render('main/blog.html.twig', [
            'controller_name' => 'MainController',
            'first_post'      => 'This is first post',
            'second_post'     => 'This is second post',
            'third_post'      => $posts,
        ]);
    }

//    /**
//     * @Route("/blog/{page}", name="blog_list", requirements={"page"="\d+"})
//     */
//    public function blog_list(int $page)
//    {
//        return $this->render('main/blog.html.twig', [
//            'page' => $page,
//        ]);
//    }

    /**
     * @Route("/blog/{slug}", name="blog_post")
     */
    public function blog_post(Notes $slug)
    {
        return $this->render('main/post.html.twig', [
            'post_title'       => $slug->getTitle(),
            'post_description' => $slug->getDescription(),
            'post_created'     => $slug->getCreated(),
        ]);
    }


}
