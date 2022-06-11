<?php

namespace ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ClubBundle\Service\AnneeBissextileService;
 
use ClubBundle\Entity\Club;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Club/Default/index.html.twig');
    }

    public function anneeBissextileAction($nbAnnee) {
        $anneeBissextile = $this->get('annee.bissextile');
        $isBissextile = $anneeBissextile->anneeBissextile($nbAnnee);
        $annee = $anneeBissextile->getAnneeCreation() + $nbAnnee;
        $reponse = $isBissextile ? 
                $anneeBissextile->getAnneeCreation()." + ".$nbAnnee." = ".$annee." est une année bissextile" : 
                $anneeBissextile->getAnneeCreation()." + ".$nbAnnee." = ".$annee." n'est pas une année bissextile";
        return new Response($reponse);
    }
}
