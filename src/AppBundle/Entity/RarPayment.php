<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarPayment
 *
 * @ORM\Table(name="rar_payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarPaymentRepository")
 */
class RarPayment
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
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePaiement", type="datetime")
     */
    private $datePaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="typePaiement", type="string", length=255)
     */
    private $typePaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCashing", type="datetime")
     */
    private $dateCashing;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="RarOrder", inversedBy="payments", fetch="EAGER")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payments", fetch="EAGER")
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
     * Set amount
     *
     * @param float $amount
     *
     * @return RarPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set datePaiement
     *
     * @param \DateTime $datePaiement
     *
     * @return RarPayment
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return \DateTime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set typePaiement
     *
     * @param string $typePaiement
     *
     * @return RarPayment
     */
    public function setTypePaiement($typePaiement)
    {
        $this->typePaiement = $typePaiement;

        return $this;
    }

    /**
     * Get typePaiement
     *
     * @return string
     */
    public function getTypePaiement()
    {
        return $this->typePaiement;
    }

    /**
     * Set dateCashing
     *
     * @param \DateTime $dateCashing
     *
     * @return RarPayment
     */
    public function setDateCashing($dateCashing)
    {
        $this->dateCashing = $dateCashing;

        return $this;
    }

    /**
     * Get dateCashing
     *
     * @return \DateTime
     */
    public function getDateCashing()
    {
        return $this->dateCashing;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return RarPayment
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RarPayment
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
     * Set User
     *
     * @param \AppBundle\Entity\User $user
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
}

