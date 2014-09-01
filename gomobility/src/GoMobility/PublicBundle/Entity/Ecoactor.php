<?php

namespace GoMobility\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ecoactor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GoMobility\PublicBundle\Entity\EcoactorRepository")
 */
class Ecoactor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")    
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=150, unique=false)
     * @Assert\NotBlank(message="Vous n'avez pas saisi votre nom")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, unique=false)
     * @Assert\NotBlank(message="Vous n'avez pas saisi d'email")
     * @Assert\Email(
     *     message="Votre email n'est pas valide.", checkMX=false, checkHost=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=150)
     * @Assert\NotBlank(message="Vous n'avez pas saisi le type")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="string", length=255)
     * @Assert\NotBlank(message="Vous n'avez pas saisi l'adresse de départ")
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival", type="string", length=255)
     * @Assert\NotBlank(message="Vous n'avez pas saisi l'adresse d'arrivée")
     */
    private $arrival;

    /**
     * @var string
     *
     * @ORM\Column(name="start_latitude", type="string", length=255)
     */
    private $start_latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="start_longitude", type="string", length=255)
     */
    private $start_longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival_latitude", type="string", length=255)
     */
    private $arrival_latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival_longitude", type="string", length=255)
     */
    private $arrival_longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Vous n'avez pas saisi la description")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="game", type="boolean", length=1)
     */
    private $game;

    /**
     * @var float
     *
     * @ORM\Column(name="ges", type="float")
     */
    private $ges;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */    
    private $date;

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
     * Set email
     *
     * @param string $email
     * @return Ecoactor
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Ecoactor
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ecoactor
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set ges
     *
     * @param integer $ges
     * @return Ecoactor
     */
    public function setGes($ges)
    {
        $this->ges = $ges;
    
        return $this;
    }

    /**
     * Get ges
     *
     * @return integer 
     */
    public function getGes()
    {
        return $this->ges;
    }

    /**
     * Set start_latitude
     *
     * @param string $startLatitude
     * @return Ecoactor
     */
    public function setStartLatitude($startLatitude)
    {
        $this->start_latitude = $startLatitude;
    
        return $this;
    }

   

    /**
     * Get start_latitude
     *
     * @return string 
     */
    public function getStartLatitude()
    {
        return $this->start_latitude;
    }

    /**
     * Set start_longitude
     *
     * @param string $startLongitude
     * @return Ecoactor
     */
    public function setStartLongitude($startLongitude)
    {
        $this->start_longitude = $startLongitude;
    
        return $this;
    }

    /**
     * Get start_longitude
     *
     * @return string 
     */
    public function getStartLongitude()
    {
        return $this->start_longitude;
    }

    /**
     * Set arrival_latitude
     *
     * @param string $arrivalLatitude
     * @return Ecoactor
     */
    public function setArrivalLatitude($arrivalLatitude)
    {
        $this->arrival_latitude = $arrivalLatitude;
    
        return $this;
    }

    /**
     * Get arrival_latitude
     *
     * @return string 
     */
    public function getArrivalLatitude()
    {
        return $this->arrival_latitude;
    }

    /**
     * Set arrival_longitude
     *
     * @param string $arrivalLongitude
     * @return Ecoactor
     */
    public function setArrivalLongitude($arrivalLongitude)
    {
        $this->arrival_longitude = $arrivalLongitude;
    
        return $this;
    }

    /**
     * Get arrival_longitude
     *
     * @return string 
     */
    public function getArrivalLongitude()
    {
        return $this->arrival_longitude;
    }

    /**
     * Set start
     *
     * @param string $start
     * @return Ecoactor
     */
    public function setStart($start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return string 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set arrival
     *
     * @param string $arrival
     * @return Ecoactor
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
    
        return $this;
    }

    /**
     * Get arrival
     *
     * @return string 
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set game
     *
     * @param boolean $game
     * @return Ecoactor
     */
    public function setGame($game)
    {
        $this->game = $game;
    
        return $this;
    }

    /**
     * Get game
     *
     * @return boolean 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Ecoactor
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Ecoactor
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Ecoactor
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
}
