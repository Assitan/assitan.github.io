<?php

namespace GoMobility\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GoMobility\PublicBundle\Entity\CommentRepository")
 */
class Comment 
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
     * @ORM\Column(name="nom", type="string", length=150)
     * @Assert\NotBlank(message="Vous n'avez pas saisi votre nom")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     * @Assert\NotBlank(message="Vous n'avez pas saisi d'email")
     * @Assert\Email(
     *     message="Votre email n'est pas valide.", checkMX=false, checkHost=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank(message="Vous n'avez pas saisi de message")
     */
    private $message;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Ecoactor")
     */
    private $ecoactor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */    
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

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
     * @return Comment
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
     * Set message
     *
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Comment
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
     * Set ecoactor
     *
     * @param \GoMobility\PublicBundle\Entity\Ecoactor $ecoactor
     * @return Comment
     */
    public function setEcoactor(\GoMobility\PublicBundle\Entity\Ecoactor $ecoactor = null)
    {
        $this->ecoactor = $ecoactor;
    
        return $this;
    }

    /**
     * Get ecoactor
     *
     * @return \GoMobility\PublicBundle\Entity\Ecoactor 
     */
    public function getEcoactor()
    {
        return $this->ecoactor;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
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
     * @return Comment
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