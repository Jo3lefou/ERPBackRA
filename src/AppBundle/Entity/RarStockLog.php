<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockLog
 *
 * @ORM\Table(name="rar_stock_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarStockLogRepository")
 */
class RarStockLog
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
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="stockLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="RarMatter", inversedBy="stockLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="matter_id", referencedColumnName="id")
     */
    protected $matter;

    /**
     * @ORM\ManyToOne(targetEntity="RarWorkroom", inversedBy="stockLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="workroom_id", referencedColumnName="id")
     */
    protected $workroom;

    /**
     * @ORM\ManyToOne(targetEntity="RarOrder", inversedBy="stockLogs", fetch="EAGER")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;


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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return StockLog
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return StockLog
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
     * Set User
     *
     * @param \AppBundle\Entity\RarWorkroom $user
     *
     * @return User
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Matter
     *
     * @param \AppBundle\Entity\RarWorkroom $matter
     *
     * @return Matter
     */
    public function setMatter(RarMatter $matter = null)
    {
        $this->matter = $matter;
    }

    public function getMatter()
    {
        return $this->matter;
    }

    /**
     * Set Workroom
     *
     * @param \AppBundle\Entity\RarWorkroom $workroom
     *
     * @return Workroom
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

}

