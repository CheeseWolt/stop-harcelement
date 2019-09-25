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
        $alerts = $alertRepository->getStatusRatioByMonth();
        if (isset($alert)) {
            foreach ($alerts as $alert) {
                $dtv[$alert['idAlert']][$alert['mois']] = $alert['nb'];
            }
        }
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'dtv' => $dtv??null,
            'alert'=> $alerts??null
        ]);
    }
}
