<?php

namespace ClubBundle\Service;

class AnneeBissextileService {

    private $anneeCreation;

    public function __construct($annee) {
        $this->anneeCreation = $annee;
    }

    public function getAnneeCreation() {
        return $this->anneeCreation;
    }

    public function anneeBissextile($nbAnnee) {
        $annee = $this->anneeCreation + $nbAnnee;
        $isBissextile = false;

        if ($annee%4 == 0) {
            if ($annee%100 == 0 ) {
                if ($annee%400 == 0 ) {
                    $isBissextile = true;
                }
            } else {
                $isBissextile = true;
            }
        } 
        return $isBissextile;
    }
}