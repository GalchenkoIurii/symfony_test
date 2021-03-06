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

        $notes = $em->getRepository(Notes::class)->findAll();

        return $this->render('main/index.html.twig', [
            'notes'           => $notes
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $note = new Notes();
        $form = $this->createForm(NotesType::class, $note);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('add');
        }

        return $this->render('main/add.html.twig', [
            'form'            => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/blog/{page}", name="blog_list", requirements={"page"="\d+"})
//     */
//    public function blog_list(int $page)
//    {
//        return $this->render('main/add.html.twig', [
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

    /**
     * @Route("/remove/{note}", name="remove_note")
     */
    public function removeNote(Notes $note, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($note);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
