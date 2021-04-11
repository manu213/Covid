<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiService $apiService): Response
    {
        return $this->render('home/index.html.twig', [
            'data' => $apiService->getFranceData(),
            'departments' => $apiService->getAllDepartment(),
        ]);
    }
}
