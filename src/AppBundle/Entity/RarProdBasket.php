<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarProdBasket
 *
 * @ORM\Table(name="rar_prod_basket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarProdBasketRepository")
 */
class RarProdBasket
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
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * One BasketLog has ModelOrdered.
     * @ORM\OneToOne(targetEntity="RarModelOrdered")
     * @ORM\JoinColumn(name="modelOrdered_id", referencedColumnName="id")
     */
    private $modelOrdered;


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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return RarProdBasket
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
     * Set status
     *
     * @param integer $status
     *
     * @return RarProdBasket
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
     * Set ModelOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     *
     * @return ModelOrdered
     */
    public function setModelOrdered(RarModelOrdered $modelOrdered = null)
    {
        $this->modelOrdered = $modelOrdered;
    }

    public function getModelOrdered()
    {
        return $this->modelOrdered;
    }
}

