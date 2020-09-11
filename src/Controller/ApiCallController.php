<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiCallController extends AbstractController
{
    /**
     * @Route("/api/call", name="api_call")
     */
    public function index()
    {


        return $this->render('api_call/index.html.twig', [
            'controller_name' => 'ApiCallController',
        ]);
    }
}
