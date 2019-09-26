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
        for ($style = 1; $style < 3; $style++) {
            for ($mois = 1; $mois < 13; $mois++) {
                $dtv[$style][$this->monthTranslation($mois)] = "0";  // on initialise un tableau au format tab[ type de harcelement ][ mois du heacelement ] = nombre de harcelement
            }
        }
        // GRAPH 1 Victime-Témoin / Mois
        $dtvMax = 0;
        $alerts = $alertRepository->getStatusRatioByMonth();
        foreach ($alerts as $alert) {
            $dtv[$alert['idAlert']][$this->monthTranslation($alert['mois'])] = $alert['nb'];  // on remplit un tableau au format tab[ type de harcelement ][ mois du heacelement ] = nombre de harcelement
            if ($dtvMax < $alert['nb']) {
                $dtvMax = $alert['nb'];
            }
        }
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'dtv' => $dtv ?? null,
            'dtvMax' => $dtvMax,
        ]);


        // GRAPH 2 Type d'Aggression / Mois


        // GRAPH 3 Victime genre / type d'aggression


    }


    /**
     * Traduction d'un mois au format nombre vers un format lisible en français
     * @var month 
     */
    public function monthTranslation($month)
    {
        switch ($month) {
            case ('01'):
                return "Janvier";
                break;
            case ('02'):
                return "Février";
                break;
            case ('03'):
                return "Mars";
                break;
            case ('04'):
                return "Avril";
                break;
            case ('05'):
                return "Mai";
                break;
            case ('06'):
                return "Juin";
                break;
            case ('07'):
                return "Juillet";
                break;
            case ('08'):
                return "Août";
                break;
            case ('09'):
                return "Septembre";
                break;
            case ('10'):
                return "Octobre";
                break;
            case ('11'):
                return "Novembre";
                break;
            case ('12'):
                return "Décembre";
                break;
            default:
                return null;
                break;
        }
    }
}
