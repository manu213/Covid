<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/department/{department}", name="department")
     */
    public function department(ApiService $apiService, $department): Response
    {
        
        return $this->render('department/index.html.twig', [
            'data' => $apiService->getDepartmentData($department),
        ]);
    }
}
