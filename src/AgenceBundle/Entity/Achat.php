<?php

namespace AgenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Achat {

    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */  
    private $dateAchat;

    /**
     *     
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Bien")
     */
    private $biens;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Proprietaire")
     */
    private $proprietaires;



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
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     *
     * @return Achat
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set biens
     *
     * @param \AgenceBundle\Entity\Bien $biens
     *
     * @return Achat
     */
    public function setBiens(\AgenceBundle\Entity\Bien $biens = null)
    {
        $this->biens = $biens;

        return $this;
    }

    /**
     * Get biens
     *
     * @return \AgenceBundle\Entity\Bien
     */
    public function getBiens()
    {
        return $this->biens;
    }

    /**
     * Set proprietaires
     *
     * @param \AgenceBundle\Entity\Proprietaire $proprietaires
     *
     * @return Achat
     */
    public function setProprietaires(\AgenceBundle\Entity\Proprietaire $proprietaires = null)
    {
        $this->proprietaires = $proprietaires;

        return $this;
    }

    /**
     * Get proprietaires
     *
     * @return \AgenceBundle\Entity\Proprietaire
     */
    public function getProprietaires()
    {
        return $this->proprietaires;
    }
}
