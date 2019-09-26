<?php

namespace App\Controller;

use App\Repository\AlertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(AlertRepository $alertRepository)
    {
        // GRAPH 1 Victime-Témoin / Mois
        $dtvMax = 0;
        $alerts = $alertRepository->getStatusRatioByMonth();
            foreach ($alerts as $alert) {
                $dtv[$alert['idAlert']][$alert['mois']] = $alert['nb'];
                if ($dtvMax < $alert['nb']) {
                    $dtvMax = $alert['nb'];
                }
            }
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'dtv' => $dtv??null,
            'dtvMax'=> $dtvMax
        ]);

        // GRAPH 2 Type d'Aggression / Mois
        // $detMax = 0;
        // $alerts_style = $alertRepository->getAlertTypeByMonth();
        //     foreach ($alerts_style as $alert_style) {
        //         $det[$alert_style['idAlertStyle']][$alert_style['mois']] = $alert_style['nb'];
        //         if ($detMax < $alert_style['nb']) {
        //             $dtvMax = $alert_style['nb'];
        //         }
        //     }
        // return $this->render('dashboard/index.html.twig', [
        //     'controller_name' => 'DashboardController',
        //     'det' => $det??null,
        //     'detMax' => $detMax
        // ]);

        // GRAPH 3 Victime genre / type d'aggression
        

    }
}
