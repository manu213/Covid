<?php

namespace App\Controller;

use App\Service\ApiService;
use DateTime;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/department/{department}", name="department")
     */
    public function department(ApiService $apiService, $department, ChartBuilderInterface $chartBuilder): Response
    {
        $label = [];
        $hospitalises = [];
        $reanimation = [];

        for ($i = 1; $i < 8; $i++) {
            $date = new DateTime('- ' . $i . ' day');
            $datas = $apiService->getAllDataByDate($date->format('Y-m-d'));

            foreach ($datas['allFranceDataByDate'] as $data) {
                if ($data['nom'] == $department) {
                    $label[] = $data['date'];
                    $hospitalises[] = $data['nouvellesHospitalisations'];
                    $reanimation[] = $data['nouvellesReanimations'];
                }
            }
        }
// dd($hospitalises);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Nouvelles Réanimations',
                    'backgroundColor' => 'rgb(0, 255, 255)',
                    'borderColor' => 'rgb(0, 255, 255)',
                    'data' => array_reverse($reanimation),
                ],
                [
                    'label' => 'Nouvelles Hospitalisations',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_reverse($hospitalises),
                ],
            ],
        ]);

        /* $chart->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]); */

        $response = $this->render('department/index.html.twig', [
            'data' => $apiService->getDepartmentData($department),
            'chart' => $chart,
        ]);
        $response->setSharedMaxAge(3600);

        return $response;
    }
}
