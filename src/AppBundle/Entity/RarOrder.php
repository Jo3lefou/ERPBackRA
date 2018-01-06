<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarOrder
 *
 * @ORM\Table(name="rar_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarOrderRepository")
 */
class RarOrder
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
     * @var int
     *
     * @ORM\Column(name="idEshop", type="integer", nullable=true)
     */
    private $idEshop;

    /**
     * @var int
     *
     * @ORM\Column(name="proto", type="integer", nullable=true)
     */
    private $proto;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(name="idCompta", type="integer", nullable=true)
     */
    private $idCompta;

    /**
     * @var string
     *
     * @ORM\Column(name="customerName", type="string", length=255, nullable=true)
     */
    private $customerName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCivil", type="datetime")
     */
    private $dateCivil;

    /**
     * @var string
     *
     * @ORM\Column(name="dateChurch", type="datetime")
     */
    private $dateChurch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOrder", type="datetime", nullable=true)
     */
    private $dateOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="dateValidation", type="datetime", nullable=true)
     */
    private $dateValidation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMinShip", type="datetime")
     */
    private $dateMinShip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMaxShip", type="datetime")
     */
    private $dateMaxShip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateShipped", type="datetime", nullable=true)
     */
    private $dateShipped;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true, nullable=true)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="orderAcompte", type="integer", nullable=true)
     */
    private $orderAcompte;

    /**
     * @var int
     *
     * @ORM\Column(name="orderSold", type="integer", nullable=true)
     */
    private $orderSold;

    /**
     * @var int
     *
     * @ORM\Column(name="statusPaiement", type="integer", nullable=true)
     */
    private $statusPaiement;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     * #0 = Normal, 1 = Stock, 3 = Prototype
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="RarModelOrdered", mappedBy="order",cascade={"persist"}, fetch="EAGER")
     */
    private $modelsOrdered;

    /**
     * @ORM\OneToMany(targetEntity="RarOrderNotes", mappedBy="order",cascade={"persist"}, fetch="EAGER")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="RarOrderLog", mappedBy="order",cascade={"persist"}, fetch="EAGER")
     */
    private $orderLogs;

    /**
     * @ORM\OneToMany(targetEntity="RarPayment", mappedBy="order",cascade={"persist"}, fetch="EAGER")
     */
    private $payments;

    /**
     * @ORM\ManyToOne(targetEntity="RarShop", inversedBy="orders", fetch="EAGER")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
     */
    protected $shop;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="RarCustomer", inversedBy="orders",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;

    /**
     * @ORM\OneToMany(targetEntity="RarStockLog", mappedBy="order",cascade={"persist"}, fetch="EAGER")
     */
    protected $stockLogs;


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
     * Set id
     *
     * @param integer $id
     *
     * @return RarOrder
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set idEshop
     *
     * @param integer $idEshop
     *
     * @return RarOrder
     */
    public function setIdEshop($idEshop)
    {
        $this->idEshop = $idEshop;

        return $this;
    }

    /**
     * Get idEshop
     *
     * @return int
     */
    public function getIdEshop()
    {
        return $this->idEshop;
    }

    /**
     * Set proto
     *
     * @param integer $proto
     *
     * @return RarOrder
     */
    public function setProto($proto)
    {
        $this->proto = $proto;

        return $this;
    }

    /**
     * Get proto
     *
     * @return int
     */
    public function getProto()
    {
        return $this->proto;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return RarOrder
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set idCompta
     *
     * @param integer $idCompta
     *
     * @return RarOrder
     */
    public function setIdCompta($idCompta)
    {
        $this->idCompta = $idCompta;

        return $this;
    }

    /**
     * Get idCompta
     *
     * @return int
     */
    public function getIdCompta()
    {
        return $this->idCompta;
    }

    /**
     * Set dateCivil
     *
     * @param \DateTime $dateCivil
     *
     * @return RarOrder
     */
    public function setDateCivil($dateCivil)
    {
        $this->dateCivil = $dateCivil;

        return $this;
    }

    /**
     * Get dateCivil
     *
     * @return \DateTime
     */
    public function getDateCivil()
    {
        return $this->dateCivil;
    }

    /**
     * Set dateChurch
     *
     * @param string $dateChurch
     *
     * @return RarOrder
     */
    public function setDateChurch($dateChurch)
    {
        $this->dateChurch = $dateChurch;

        return $this;
    }

    /**
     * Get dateChurch
     *
     * @return string
     */
    public function getDateChurch()
    {
        return $this->dateChurch;
    }

    /**
     * Set dateOrder
     *
     * @param \DateTime $dateOrder
     *
     * @return RarOrder
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * Set dateValidation
     *
     * @param string $dateValidation
     *
     * @return RarOrder
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return string
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set dateMinShip
     *
     * @param \DateTime $dateMinShip
     *
     * @return RarOrder
     */
    public function setDateMinShip($dateMinShip)
    {
        $this->dateMinShip = $dateMinShip;

        return $this;
    }

    /**
     * Get dateMinShip
     *
     * @return \DateTime
     */
    public function getDateMinShip()
    {
        return $this->dateMinShip;
    }

    /**
     * Set dateMaxShip
     *
     * @param \DateTime $dateMaxShip
     *
     * @return RarOrder
     */
    public function setDateMaxShip($dateMaxShip)
    {
        $this->dateMaxShip = $dateMaxShip;

        return $this;
    }

    /**
     * Get dateMaxShip
     *
     * @return \DateTime
     */
    public function getDateMaxShip()
    {
        return $this->dateMaxShip;
    }

    /**
     * Set dateShipped
     *
     * @param \DateTime $dateShipped
     *
     * @return RarOrder
     */
    public function setDateShipped($dateShipped)
    {
        $this->dateShipped = $dateShipped;

        return $this;
    }

    /**
     * Get dateShipped
     *
     * @return \DateTime
     */
    public function getDateShipped()
    {
        return $this->dateShipped;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return RarOrder
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RarOrder
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
     * Set state
     *
     * @param integer $state
     *
     * @return RarOrder
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
     * Set orderAcompte
     *
     * @param integer $orderAcompte
     *
     * @return RarOrder
     */
    public function setOrderAcompte($orderAcompte)
    {
        $this->orderAcompte = $orderAcompte;

        return $this;
    }

    /**
     * Get orderAcompte
     *
     * @return int
     */
    public function getOrderAcompte()
    {
        return $this->orderAcompte;
    }

    /**
     * Set orderSold
     *
     * @param integer $orderSold
     *
     * @return RarOrder
     */
    public function setOrderSold($orderSold)
    {
        $this->orderSold = $orderSold;

        return $this;
    }

    /**
     * Get orderSold
     *
     * @return int
     */
    public function getOrderSold()
    {
        return $this->orderSold;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return RarModelOrdered
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
     * Set shop
     *
     * @param \AppBundle\Entity\RarShop $shop
     *
     * @return RarOrder
     */
    public function setShop(\AppBundle\Entity\RarShop $shop = null)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return \AppBundle\Entity\RarShop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RarOrder
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

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\RarCustomer $customer
     *
     * @return RarOrder
     */
    public function setCustomer(\AppBundle\Entity\RarCustomer $customer = null)
    {
        $this->customer = $customer;

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

    /// GETTER AND SETTER
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelsOrdered = new ArrayCollection();
        $this->stockLogs = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }


    /**
     * Add payments Payments
     *
     * @param \AppBundle\Entity\RarPayment $payments
     *
     * @return RarOrder
     */
    public function AddPayments(\AppBundle\Entity\RarPayment $payment)
    {
        $this->payments[] = $payment;
        $payment->setOrder($this);
        return $this;
    }

    /**
     * Remove payments
     *
     * @param \AppBundle\Entity\RarPayment $payments
     */
    public function removePayments(\AppBundle\Entity\RarPayment $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }




    /**
     * Add modelOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     *
     * @return RarOrder
     */
    public function AddModelsOrdered(\AppBundle\Entity\RarModelOrdered $modelOrdered)
    {
        $this->modelsOrdered[] = $modelOrdered;
        $modelOrdered->setOrder($this);
        return $this;
    }

    /**
     * Remove modelOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     */
    public function removeModelsOrdered(\AppBundle\Entity\RarModelOrdered $modelOrdered)
    {
        $this->modelsOrdered->removeElement($modelOrdered);
    }

    /**
     * Get modelOrdereds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModelsOrdered()
    {
        return $this->modelsOrdered;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\RarModel
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * Add notes
     *
     * @param \AppBundle\Entity\RarOrderNotes $notes
     *
     * @return RarOrder
     */
    public function AddNotes(\AppBundle\Entity\RarOrderNotes $note)
    {
        $this->notes[] = $note;
        $note->setOrder($this);
        return $this;
    }

    /**
     * Remove modelOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     */
    public function removeNotes(\AppBundle\Entity\RarOrderNotes $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get modelOrdereds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    // 
    /**
     * Add stockLogs //orderLogs OrderLogs orderLog
     *
     * @param \AppBundle\Entity\RarOrderLog $orderLogs
     *
     * @return RarOrder
     */
    public function AddOrderLogs(\AppBundle\Entity\RarOrderLog $orderLog)
    {
        $this->orderLogs[] = $orderLog;
        $orderLog->setOrder($this);
        return $this;
    }

    /**
     * Remove stockLog
     *
     * @param \AppBundle\Entity\RarOrderLog $orderLogs
     */
    public function removeOrderLogs(\AppBundle\Entity\RarOrderLog $orderLog)
    {
        $this->orderLogs->removeElement($orderLog);
    }

    /**
     * Get stockLogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderLogs()
    {
        return $this->orderLogs;
    }
    
}
