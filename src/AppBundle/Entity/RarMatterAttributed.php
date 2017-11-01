<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarMatterAttributed
 *
 * @ORM\Table(name="rar_matter_attributed")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarMatterAttributedRepository")
 */
class RarMatterAttributed
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
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="RarModel", inversedBy="matterAttributed", cascade={"persist"})
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @ORM\ManyToOne(targetEntity="RarMatter", inversedBy="matterAttributed", cascade={"persist"})
     * @ORM\JoinColumn(name="matter_id", referencedColumnName="id")
     */
    protected $matter;

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
     * @return RarMatterAttributed
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
     * @return RarMatterAttributed
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
     * Set Model
     *
     * @param \AppBundle\Entity\RarModel $model
     *
     * @return Order
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
     * Set Matter
     *
     * @param \AppBundle\Entity\RarModel $matter
     *
     * @return Order
     */
    public function setMatter(RarMatter $matter = null)
    {
        $this->matter = $matter;
    }

    public function getMatter()
    {
        return $this->matter;
    }
}

