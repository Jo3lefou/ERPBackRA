<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * RarModel
 *
 * @ORM\Table(name="rar_model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarModelRepository")
 */
class RarModel
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
     * @ORM\Column(name="collectionId", type="integer")
     */
    private $collectionId;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=30)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="prixHT", type="float")
     */
    private $prixHT;

    /**
     * @var float
     *
     * @ORM\Column(name="prixShop", type="float")
     */
    private $prixShop;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_shop", type="boolean")
     */
    private $isShop;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_contract", type="boolean")
     */
    private $isContract;

    /**
     * @var string
     *
     * @ORM\Column(name="url_img", type="string", length=255, nullable=true)
     */
    private $urlImg;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="min_ship_week", type="integer")
     */
    private $minShipWeek;

    /**
     * @var int
     *
     * @ORM\Column(name="max_ship_week", type="integer")
     */
    private $maxShipWeek;

    /**
     * @var int
     *
     * @ORM\Column(name="fkEshop", type="integer", nullable=true)
     */
    private $fkEshop;

    /**
     * @ORM\OneToMany(targetEntity="RarSize", mappedBy="model", cascade="persist")
     */
    protected $sizes;

    /**
     * @ORM\OneToMany(targetEntity="RarModelOrdered", mappedBy="model")
     */
    protected $modelsOrdered;

    /**
     * @ORM\ManyToOne(targetEntity="RarWorkroom", inversedBy="models",cascade={"persist"})
     * @ORM\JoinColumn(name="workroom_id", referencedColumnName="id")
     */
    protected $workroom;

    /**
     * @ORM\OneToMany(targetEntity="RarMatterAttributed", mappedBy="model",cascade={"persist"})
     */
    protected $matterAttributed;



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
     * Set collectionId
     *
     * @param integer $collectionId
     *
     * @return RarModel
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;

        return $this;
    }

    /**
     * Get collectionId
     *
     * @return int
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return RarModel
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
     * Set name
     *
     * @param string $name
     *
     * @return RarModel
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
     * Set prixHT
     *
     * @param float $prixHT
     *
     * @return RarModel
     */
    public function setPrixHT($prixHT)
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    /**
     * Get prixHT
     *
     * @return float
     */
    public function getPrixHT()
    {
        return $this->prixHT;
    }

    /**
     * Set prixShop
     *
     * @param float $prixShop
     *
     * @return RarModel
     */
    public function setPrixShop($prixShop)
    {
        $this->prixShop = $prixShop;

        return $this;
    }

    /**
     * Get prixShop
     *
     * @return float
     */
    public function getPrixShop()
    {
        return $this->prixShop;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RarModel
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
     * Set isShop
     *
     * @param boolean $isShop
     *
     * @return RarModel
     */
    public function setIsShop($isShop)
    {
        $this->isShop = $isShop;

        return $this;
    }

    /**
     * Get isShop
     *
     * @return bool
     */
    public function getIsShop()
    {
        return $this->isShop;
    }

    /**
     * Set isContract
     *
     * @param boolean $isContract
     *
     * @return RarModel
     */
    public function setIsContract($isContract)
    {
        $this->isContract = $isContract;

        return $this;
    }

    /**
     * Get isContract
     *
     * @return bool
     */
    public function getIsContract()
    {
        return $this->isContract;
    }

    /**
     * Set urlImg
     *
     * @param string $urlImg
     *
     * @return RarModel
     */
    public function setUrlImg($urlImg)
    {
        $this->urlImg = $urlImg;

        return $this;
    }

    /**
     * Get urlImg
     *
     * @return string
     */
    public function getUrlImg()
    {
        return $this->urlImg;
    }

    /**
     * Set urlThumb
     *
     * @param string $urlThumb
     *
     * @return RarModel
     */
    public function setUrlThumb($urlThumb)
    {
        $this->urlThumb = $urlThumb;

        return $this;
    }

    /**
     * Get urlThumb
     *
     * @return string
     */
    public function getUrlThumb()
    {
        return $this->urlThumb;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return RarModel
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
     * Set category
     *
     * @param integer $category
     *
     * @return RarModel
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set minShipWeek
     *
     * @param integer $minShipWeek
     *
     * @return RarModel
     */
    public function setMinShipWeek($minShipWeek)
    {
        $this->minShipWeek = $minShipWeek;

        return $this;
    }

    /**
     * Get minShipWeek
     *
     * @return int
     */
    public function getMinShipWeek()
    {
        return $this->minShipWeek;
    }

    /**
     * Set maxShipWeek
     *
     * @param integer $maxShipWeek
     *
     * @return RarModel
     */
    public function setMaxShipWeek($maxShipWeek)
    {
        $this->maxShipWeek = $maxShipWeek;

        return $this;
    }

    /**
     * Get maxShipWeek
     *
     * @return int
     */
    public function getMaxShipWeek()
    {
        return $this->maxShipWeek;
    }

    /**
     * Set fkEshop
     *
     * @param integer $fkEshop
     *
     * @return RarModel
     */
    public function setFkEshop($fkEshop)
    {
        $this->fkEshop = $fkEshop;

        return $this;
    }

    /**
     * Get fkEshop
     *
     * @return int
     */
    public function getFkEshop()
    {
        return $this->fkEshop;
    }

    /// GETTER AND SETTER
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sizes = new ArrayCollection();
        $this->modelsOrdered = new ArrayCollection();
        $this->matterAttributed = new ArrayCollection();
    }

    /**
     * Add size
     *
     * @param \AppBundle\Entity\RarSize $size
     *
     * @return RarModel
     */
    public function addSizes(\AppBundle\Entity\RarSize $size)
    {
        $this->sizes[] = $size;

        return $this;
    }

    /**
     * Remove size
     *
     * @param \AppBundle\Entity\RarSize $size
     */
    public function removeSizes(\AppBundle\Entity\RarSize $size)
    {
        $this->sizes->removeElement($size);
    }

    /**
     * Get sizes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Get ActiveSizes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveSizes()
    {
        return $this->sizes->matching(
            Criteria::create()->where(
                Criteria::expr()->eq('isActive', true)
            )
        );
    }

    /**
     * Add modelsOrdered
     *
     * @param \AppBundle\Entity\RarModelOrdered $modelOrdered
     *
     * @return RarModel
     */
    public function AddModelsOrdered(\AppBundle\Entity\RarModelOrdered $modelOrdered)
    {
        $this->modelsOrdered[] = $modelOrdered;
        
        return $this;
    }

    /**
     * Remove modelsOrdered
     *
     * @param \AppBundle\Entity\RarModelsOrdered $modelsOrdered
     */
    public function removeModelsOrdered(\AppBundle\Entity\RarModelOrdered $modelOrdered)
    {
        $this->modelsOrdered->removeElement($modelOrdered);
    }

    /**
     * Get modelsOrdered
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModelsOrdered()
    {
        return $this->modelsOrdered;
    }

    /***********/

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
}

