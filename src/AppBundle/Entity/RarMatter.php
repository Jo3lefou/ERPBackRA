<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarMatter
 *
 * @ORM\Table(name="rar_matter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarMatterRepository")
 */
class RarMatter
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=127)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=127)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="minShip", type="integer")
     */
    private $minShip;

    /**
     * @var int
     *
     * @ORM\Column(name="maxShip", type="integer")
     */
    private $maxShip;

    /**
     * @var string
     *
     * @ORM\Column(name="composition", type="text", nullable=true)
     */
    private $composition;

    /**
     * @var float
     *
     * @ORM\Column(name="width", type="float")
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    ///////*********************///////
    //            LINKS
    ///////*********************///////

    /**
     * @ORM\ManyToOne(targetEntity="RarMatterProvider", inversedBy="matters", fetch="EAGER")
     * @ORM\JoinColumn(name="matterprovider_id", referencedColumnName="id")
     */
    protected $matterprovider;

    /**
     * @ORM\OneToMany(targetEntity="RarMatterAttributed", mappedBy="matter")
     */
    protected $matterAttributed;

    /**
     * @ORM\OneToMany(targetEntity="RarStockLog", mappedBy="matter")
     */
    protected $stockLogs;


    /// GETTER AND SETTER
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matterAttributed = new ArrayCollection();
    }

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
     * @param string $name
     *
     * @return RarMatter
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
     * Set sku
     *
     * @param string $sku
     *
     * @return RarMatter
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return RarMatter
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set minShip
     *
     * @param integer $minShip
     *
     * @return RarMatter
     */
    public function setMinShip($minShip)
    {
        $this->minShip = $minShip;

        return $this;
    }

    /**
     * Get minShip
     *
     * @return int
     */
    public function getMinShip()
    {
        return $this->minShip;
    }

    /**
     * Set maxShip
     *
     * @param integer $maxShip
     *
     * @return RarMatter
     */
    public function setMaxShip($maxShip)
    {
        $this->maxShip = $maxShip;

        return $this;
    }

    /**
     * Get maxShip
     *
     * @return int
     */
    public function getMaxShip()
    {
        return $this->maxShip;
    }

    /**
     * Set composition
     *
     * @param string $composition
     *
     * @return RarMatter
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return RarMatter
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RarMatter
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RarMatter
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set matterprovider
     *
     * @param \AppBundle\Entity\User $matterprovider
     *
     * @return RarOrder
     */
    public function setMatterprovider(\AppBundle\Entity\RarMatterProvider $matterprovider = null)
    {
        $this->matterprovider = $matterprovider;

        return $this;
    }

    /**
     * Get matterprovider
     *
     * @return \AppBundle\Entity\User
     */
    public function getMatterprovider()
    {
        return $this->matterprovider;
    }

    /**
     * Add matterAttributed
     *
     * @param \AppBundle\Entity\RarMatterAttributed $matterAttributed
     *
     * @return RarModel
     */
    public function AddMatterAttributed(\AppBundle\Entity\RarMatterAttributed $matterAttribut)
    {
        $this->matterAttributed[] = $matterAttribut;
        
        return $this;
    }

    /**
     * Remove matterAttributed
     *
     * @param \AppBundle\Entity\RarMatterAttributed $matterAttributed
     */
    public function removeMatterAttributed(\AppBundle\Entity\RarMatterAttributed $matterAttribut)
    {
        $this->matterAttributed->removeElement($matterAttribut);
    }

    /**
     * Get matterAttributed
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatterAttributed()
    {
        return $this->matterAttributed;
    }
}

