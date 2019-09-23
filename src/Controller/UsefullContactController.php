<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsefullContactController extends AbstractController
{
    /**
     * @Route("/usefull/contact", name="usefull_contact")
     */
    public function index()
    {
        return $this->render('usefull_contact/index.html.twig', [
            'controller_name' => 'UsefullContactController',
        ]);
    }
}
