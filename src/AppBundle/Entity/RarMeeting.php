<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarMeeting
 *
 * @ORM\Table(name="rar_meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarMeetingRepository")
 */
class RarMeeting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time", nullable=true)
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;
    /* 
    *
    * TYPE CHOICE
    * 0 - Autre
    * Sans envoi de mail
    * 1 - 1er Rendez-vous (Découverte)
    * Email Envoi confirmation - 1semaine avant rendez-vous avec questionnaire (je valide et confirme ma réponse) - 3j rappelle confirmation rendez-vous (flag si non réponse sur calendrier)
    * 2 - 2eme rendez-vous (Réessayage) (x)
    * Email Envoi confirmation
    * 3 - 1ere essayage (après commande)
    * Email Envoi confirmation
    * 4 - 2eme essayage (x)
    * Email Envoi confirmation
    * 5 - Pick up on store
    * Email Envoi confirmation
    *
    */

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="notifStatus", type="integer")
     */
    private $notifStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;
    /*
    * 0 - booked
    * 1 - passed
    * 2 - canceled
    */


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meetings", cascade="persist")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sales", cascade="persist")
     * @ORM\JoinColumn(name="sale_id", referencedColumnName="id")
     */
    protected $sale;

    /**
     * @ORM\ManyToOne(targetEntity="RarLocation", inversedBy="meetings", cascade="persist")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="RarCustomer", inversedBy="meetings", cascade="persist")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param \DateTime $name
     *
     * @return RarMeeting
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return RarMeeting
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return RarMeeting
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return RarMeeting
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return RarMeeting
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return RarMeeting
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RarMeeting
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set notifStatus
     *
     * @param integer $notifStatus
     *
     * @return RarMeeting
     */
    public function setNotifStatus($notifStatus)
    {
        $this->notifStatus = $notifStatus;

        return $this;
    }

    /**
     * Get notifStatus
     *
     * @return int
     */
    public function getNotifStatus()
    {
        return $this->notifStatus;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return RarMeeting
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\RarLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set location
     *
     * @param \AppBundle\Entity\RarLocation $location
     *
     * @return RarOrder
     */
    public function setLocation(\AppBundle\Entity\RarLocation $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RarMeeting
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get sale
     *
     * @return \AppBundle\Entity\User
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Set sale
     *
     * @param \AppBundle\Entity\User $sale
     *
     * @return RarMeeting
     */
    public function setSale(\AppBundle\Entity\User $sale = null)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\RarCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\RarCustomer $customer
     *
     * @return RarCustomer
     */
    public function setCustomer(\AppBundle\Entity\RarCustomer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }





}

