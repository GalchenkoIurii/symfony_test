<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
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
}
