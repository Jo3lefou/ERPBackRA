<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * RarModelOrdered
 *
 * @ORM\Table(name="rar_model_ordered")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarModelOrderedRepository")
 */
class RarModelOrdered
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
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var float
     *
     * @ORM\Column(name="heels", type="float", nullable=true)
     */
    private $heels;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_commentInvoice", type="boolean", nullable=true)
     */
    private $isCommentInvoice;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="prixSoldHT", type="float", nullable=true)
     */
    private $prixSoldHT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="minProdShip", type="datetime", nullable=true)
     */
    private $minProdShip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="maxProdShip", type="datetime", nullable=true)
     */
    private $maxProdShip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_shipping", type="datetime", nullable=true)
     */
    private $dateShipping;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\OneToMany(targetEntity="RarOrderLog", mappedBy="modelOrdered",cascade={"persist"}, fetch="EAGER")
     */
    private $orderLogs;

    /**
     * @ORM\OneToOne(targetEntity="RarProdBasket", mappedBy="modelOrdered",cascade={"persist"}, fetch="EAGER")
     */
    private $prodBasket;

    /**
     * @ORM\ManyToOne(targetEntity="RarModel", inversedBy="modelsOrdered",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @ORM\ManyToOne(targetEntity="RarOrder", inversedBy="modelsOrdered",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="RarWorkroom", inversedBy="modelsOrdered",cascade={"persist"})
     * @ORM\JoinColumn(name="workroom_id", referencedColumnName="id")
     */
    protected $workroom;
    


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
     * Set size
     *
     * @param string $size
     *
     * @return RarModelOrdered
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set heels
     *
     * @param float $heels
     *
     * @return RarModelOrdered
     */
    public function setHeels($heels)
    {
        $this->heels = $heels;

        return $this;
    }

    /**
     * Get heels
     *
     * @return float
     */
    public function getHeels()
    {
        return $this->heels;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RarModelOrdered
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
     * Set isCommentInvoice
     *
     * @param boolean $isVat
     *
     * @return RarModelOrdered
     */
    public function setIsCommentInvoice($isCommentInvoice)
    {
        $this->isCommentInvoice = $isCommentInvoice;

        return $this;
    }

    /**
     * Get isCommentInvoice
     *
     * @return bool
     */
    public function getIsCommentInvoice()
    {
        return $this->isCommentInvoice;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return RarModelOrdered
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set prixSoldHT
     *
     * @param float $prixSoldHT
     *
     * @return RarModelOrdered
     */
    public function setPrixSoldHT($prixSoldHT)
    {
        $this->prixSoldHT = $prixSoldHT;

        return $this;
    }

    /**
     * Get prixSoldHT
     *
     * @return float
     */
    public function getPrixSoldHT()
    {
        return $this->prixSoldHT;
    }

    /**
     * Set minProdShip
     *
     * @param \DateTime $minProdShip
     *
     * @return RarModelOrdered
     */
    public function setMinProdShip($minProdShip)
    {
        $this->minProdShip = $minProdShip;

        return $this;
    }

    /**
     * Get minProdShip
     *
     * @return \DateTime
     */
    public function getMinProdShip()
    {
        return $this->minProdShip;
    }

    /**
     * Set maxProdShip
     *
     * @param \DateTime $maxProdShip
     *
     * @return RarModelOrdered
     */
    public function setMaxProdShip($maxProdShip)
    {
        $this->maxProdShip = $maxProdShip;

        return $this;
    }

    /**
     * Get maxProdShip
     *
     * @return \DateTime
     */
    public function getMaxProdShip()
    {
        return $this->maxProdShip;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return RarModelOrdered
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateShipping
     *
     * @param \DateTime $dateShipping
     *
     * @return RarModelOrdered
     */
    public function setDateShipping($dateShipping)
    {
        $this->dateShipping = $dateShipping;

        return $this;
    }

    /**
     * Get dateShipping
     *
     * @return \DateTime
     */
    public function getDateShipping()
    {
        return $this->dateShipping;
    }


    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return RarModelOrdered
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }


    /**
     * Set Order
     *
     * @param \AppBundle\Entity\RarOrder $order
     *
     * @return Order
     */
    public function setOrder(RarOrder $order = null)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set Model
     *
     * @param \AppBundle\Entity\RarModel $model
     *
     * @return Model
     */
    public function setModel(RarModel $model = null)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set Workroom
     *
     * @param \AppBundle\Entity\RarWorkroom $workroom
     *
     * @return Order
     */
    public function setWorkroom(RarWorkroom $workroom = null)
    {
        $this->workroom = $workroom;
    }

    public function getWorkroom()
    {
        return $this->workroom;
    }

    
    /**
     * Set ProdBasket
     *
     * @param \AppBundle\Entity\RarProdBasket $prodBasket
     *
     * @return ProdBasket
     */
    public function setProdBasket(RarProdBasket $prodBasket = null)
    {
        $this->prodBasket = $prodBasket;
    }

    public function getProdBasket()
    {
        return $this->prodBasket;
    }

    //orderLogs

    public function getOrderLogs()
    {
        return $this->orderLogs;
    }
}

