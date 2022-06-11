<?php

namespace AgenceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Bien {
    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "erreur.bien.min.nomBien",
     * )
     */
    private $nomBien;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */  
    private $dateConstruction;
    /**
     * @ORM\Column(type="integer")
     */  
    private $prix;
    /**
     * @ORM\ManyToMany(targetEntity="Visiteur")
     */
    private $visiteurs;
    /**
     * @ORM\ManyToOne(targetEntity="TypeBien")
     * @Assert\NotBlank()
     */
    private $types;
    
    /**
     * @ORM\OneToMany(targetEntity="Achat", mappedBy="biens")
    */
    private $achat;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visiteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomBien
     *
     * @param string $nomBien
     *
     * @return Bien
     */
    public function setNomBien($nomBien)
    {
        $this->nomBien = $nomBien;

        return $this;
    }

    /**
     * Get nomBien
     *
     * @return string
     */
    public function getNomBien()
    {
        return $this->nomBien;
    }

    /**
     * Set dateConstruction
     *
     * @param \DateTime $dateConstruction
     *
     * @return Bien
     */
    public function setDateConstruction($dateConstruction)
    {
        $this->dateConstruction = $dateConstruction;

        return $this;
    }

    /**
     * Get dateConstruction
     *
     * @return \DateTime
     */
    public function getDateConstruction()
    {
        return $this->dateConstruction;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Bien
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Add visiteur
     *
     * @param \AgenceBundle\Entity\Visiteur $visiteur
     *
     * @return Bien
     */
    public function addVisiteur(\AgenceBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs[] = $visiteur;
        return $this;
    }

    /**
     * Remove visiteur
     *
     * @param \AgenceBundle\Entity\Visiteur $visiteur
     */
    public function removeVisiteur(\AgenceBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs->removeElement($visiteur);
    }

    /**
     * Get visiteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisiteurs()
    {
        return $this->visiteurs;
    }

    /**
     * Set types
     *
     * @param \AgenceBundle\Entity\TypeBien $types
     *
     * @return Bien
     */
    public function setTypes(\AgenceBundle\Entity\TypeBien $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return \AgenceBundle\Entity\TypeBien
     */
    public function getTypes()
    {
        return $this->types;
    }


    /**
     * Set achat
     *
     * @param \AgenceBundle\Entity\Achat $achat
     *
     * @return Bien
     */
    public function setAchat(\AgenceBundle\Entity\Achat $achat = null)
    {
        $this->achat = $achat;

        return $this;
    }

    /**
     * Get achat
     *
     * @return \AgenceBundle\Entity\Achat
     */
    public function getAchat()
    {
        return $this->achat;
    }

    /**
     * Add achat
     *
     * @param \AgenceBundle\Entity\Achat $achat
     *
     * @return Bien
     */
    public function addAchat(\AgenceBundle\Entity\Achat $achat)
    {
        $this->achat[] = $achat;

        return $this;
    }

    /**
     * Remove achat
     *
     * @param \AgenceBundle\Entity\Achat $achat
     */
    public function removeAchat(\AgenceBundle\Entity\Achat $achat)
    {
        $this->achat->removeElement($achat);
    }
}
