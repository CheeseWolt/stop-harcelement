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
    }
}
