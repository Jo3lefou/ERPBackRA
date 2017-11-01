<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarOrderLog
 *
 * @ORM\Table(name="rar_order_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderLogRepository")
 */
class RarOrderLog
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="RarOrder", inversedBy="orderLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="RarWorkroom", inversedBy="orderLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="workroom_id", referencedColumnName="id")
     */
    protected $workroom;

    /**
     * @ORM\ManyToOne(targetEntity="RarModelOrdered", inversedBy="orderLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="modelOrdered_id", referencedColumnName="id")
     */
    protected $modelOrdered;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orderLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OrderLog
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
     * Set message
     *
     * @param string $message
     *
     * @return OrderLog
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
     * Set order
     *
     * @param \AppBundle\Entity\RarOrder $order
     *
     * @return RarOrder
     */
    public function setOrder(\AppBundle\Entity\RarOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\RarOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set workroom
     *
     * @param \AppBundle\Entity\RarWorkroom $workroom
     *
     * @return RarWorkroom
     */
    public function setWorkroom(\AppBundle\Entity\RarWorkroom $workroom = null)
    {
        $this->workroom = $workroom;

        return $this;
    }

    /**
     * Get workroom
     *
     * @return \AppBundle\Entity\RarWorkroom
     */
    public function getWorkroom()
    {
        return $this->workroom;
    }
    //

    /**
     * Set modelOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     *
     * @return RarModelOrdered
     */
    public function setModelOrdered(\AppBundle\Entity\RarModelOrdered $modelOrdered = null)
    {
        $this->modelOrdered = $modelOrdered;

        return $this;
    }

    /**
     * Get modelOrdered
     *
     * @return \AppBundle\Entity\RarModelOrdered
     */
    public function getModelOrdered()
    {
        return $this->modelOrdered;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return User
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

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
}

