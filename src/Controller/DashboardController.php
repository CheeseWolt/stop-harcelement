<?php

namespace App\Controller;

use App\Repository\SexRepository;
use App\Repository\AlertRepository;
use App\Repository\AlertStyleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(AlertRepository $alertRepository, AlertStyleRepository $alertStyleRepository, SexRepository $sexRepository)
    {
        // GRAPH 1 Victime-Témoin / Mois
        $dtvMax = 0;
        $alerts = $alertRepository->getStatusRatioByMonth(); // on recupére les "status" par mois

        // on initialise un tableau au format tab[ type de harcelement ][ mois du heacelement ] = nombre de harcelement
        for ($status = 1; $status < 3; $status++) {
            for ($mois = 1; $mois < 13; $mois++) {
                $dtv[$status][$this->monthTranslation($mois)] = "0";
                $month[] = $this->monthTranslation($mois);
            }
        }

        foreach ($alerts as $alert) {
            $dtv[$alert['idAlert']][$this->monthTranslation($alert['mois'])] = $alert['nb'];  // on remplit un tableau au format tab[ style de harcelement ][ mois du heacelement ] = nombre de harcelement
            if ($dtvMax < $alert['nb']) {
                $dtvMax = $alert['nb'];
            }
        }


        // GRAPH 2 Type d'Aggression / Mois -> abbrégé "tam"
        // on veux un tableau: tab[typeHarcelement][mois] = nombreDeCas
        $tamMax = 0;
        $styles = $alertStyleRepository->getStylesByMonth();
        $nbStyles = $alertStyleRepository->findAll();
        // on initialise les mois de chaques style de harclement
        foreach($nbStyles as $nb) {
            for ($mois = 1; $mois < 13; $mois++) {
                $tam[$nb->getName()][$this->monthTranslation($mois)] = "0";  
            }
        }

        foreach ($styles as $style) {
            $tam[$style['typeAlert']][$this->monthTranslation($style['month'])] = $style['nbAlert'];  // on remplit un tableau au format tab[ type de harcelement ][ mois du heacelement ] = nombre de harcelement
            if ($tamMax < max($tam)) {
                $tamMax = $style['nbAlert'];
            }
        }


        // GRAPH 3 Victime genre / type d'aggression
        // on veux un tableau : tab[alertStyle][sex] = nombreDeCas
        $alertsByTypeAndBySexes = $alertRepository->getVictimGenreByAlertType();
        $sexs = $sexRepository->findAll();

        // on initialise un tableau au format tab[alertStyle][sex] = nombreDeCas
        foreach($nbStyles as $nb)
        {
            for($sex = 0; $sex < count($sexs); $sex++)
            {
                $tag[$nb->getName()][$sexs[$sex]->getName()] = "0";
            }
        }
        foreach($alertsByTypeAndBySexes as $alertsByTypeAndBySexe)
        {
            $tag[$alertsByTypeAndBySexe['typeAlert']][$alertsByTypeAndBySexe['sexe']] = $alertsByTypeAndBySexe['nbAlert'];
        }


        //GRAPH 4 - tranches horaires
        $hours = $alertRepository->getHour();


        //GRAPH 5 - Localistation des incidents
        $places = $alertRepository->getPlace();


        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'dtv' => $dtv ?? null,
            'dtvMax' => $dtvMax,
            'tam'=> $tam,
            'tamMax'=> $tamMax,
            'month'=> $month,
            'hours' => $hours,
            'places' => $places,
            'tag' => $tag ?? null,
        ]);       
    }
    

    /**
     * Traduction d'un mois au format nombre vers un format lisible en français
     */
    public function monthTranslation(int $month)
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
