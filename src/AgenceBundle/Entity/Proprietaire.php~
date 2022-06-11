<?php

namespace AgenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Proprietaire {

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
     *      minMessage = "erreur.proprietaire.min.nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "erreur.proprietaire.min.prenom")
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity="Achat", mappedBy="proprietaires")
    */
    private $achat;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Proprietaire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Proprietaire
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set achat
     *
     * @param \AgenceBundle\Entity\Achat $achat
     *
     * @return Proprietaire
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
     * Constructor
     */
    public function __construct()
    {
        $this->achat = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add achat
     *
     * @param \AgenceBundle\Entity\Achat $achat
     *
     * @return Proprietaire
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

    public function getPrenomNom()
    {
        return $this->nom." ".$this->prenom;
    }
}
