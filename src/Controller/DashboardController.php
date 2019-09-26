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


        // GRAPH 3 Victime genre / type d'aggression


    }
}
