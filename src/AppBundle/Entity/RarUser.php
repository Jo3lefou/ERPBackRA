<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarUser
 *
 * @ORM\Table(name="rar_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarUserRepository")
 */
class RarUser
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
     * @ORM\Column(name="user_type", type="integer")
     */
    private $userType;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var int
     *
     * @ORM\Column(name="user_belong", type="integer", nullable=true)
     */
    private $userBelong;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=100, unique=true)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=255)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_extension", type="string", length=10, unique=true)
     */
    private $userExtension;

    /**
     * @var string
     *
     * @ORM\Column(name="user_address", type="string", length=255, nullable=true)
     */
    private $userAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="user_zipcode", type="string", length=20, nullable=true)
     */
    private $userZipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="user_city", type="string", length=255, nullable=true)
     */
    private $userCity;

    /**
     * @var string
     *
     * @ORM\Column(name="user_country", type="string", length=255, nullable=true)
     */
    private $userCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=255)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_phone", type="string", length=255)
     */
    private $userPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="user_lang", type="string", length=3)
     */
    private $userLang;

    /**
     * @var string
     *
     * @ORM\Column(name="user_color", type="string", length=7)
     */
    private $userColor;

    /**
     * @var int
     *
     * @ORM\Column(name="user_contrat", type="integer", nullable=true)
     */
    private $userContrat;

    /**
     * @var float
     *
     * @ORM\Column(name="user_contratAmount", type="float", nullable=true)
     */
    private $userContratAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="user_vatnum", type="string", length=255, nullable=true)
     */
    private $userVatnum;

    /**
     * @var \Doctrine\Common\Collections\Collection|RarShop[]
     *
     * @ORM\ManyToMany(targetEntity="RarShop", inversedBy="users")
     * @ORM\JoinTable(
     *  name="user_shops",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="rar_shop_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $shops;


    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->shops = new ArrayCollection();
    }
    /**
     * @param RarShop $shops
     */
    public function addShops(RarShop $shops)
    {
        if ($this->shops->contains($shops)) {
            return;
        }
        $this->shops->add($shops);
        $shops->addUser($this);
    }
    /**
     * @param RarShop $shops
     */
    public function removeShops(RarShop $shops)
    {
        if (!$this->shops->contains($shops)) {
            return;
        }
        $this->shops->removeElement($shops);
        $shops->removeUser($this);
    }
    /**
     * Get Shops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShops(RarShop $shops)
    {
        return $this->shops;
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
     * Set userType
     *
     * @param integer $userType
     *
     * @return RarUser
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return int
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set userBelong
     *
     * @param integer $userBelong
     *
     * @return RarUser
     */
    public function setUserBelong($userBelong)
    {
        $this->userBelong = $userBelong;

        return $this;
    }

    /**
     * Get userBelong
     *
     * @return int
     */
    public function getUserBelong()
    {
        return $this->userBelong;
    }

    /**
     * Set userLogin
     *
     * @param string $userLogin
     *
     * @return RarUser
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    /**
     * Get userLogin
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return RarUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return RarUser
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }


    /**
     * Set userExtension
     *
     * @param string $userExtension
     *
     * @return RarUser
     */
    public function setUserExtension($userExtension)
    {
        $this->userExtension = $userExtension;

        return $this;
    }

    /**
     * Get userExtension
     *
     * @return string
     */
    public function getUserExtension()
    {
        return $this->userExtension;
    }

    /**
     * Set userAddress
     *
     * @param string $userAddress
     *
     * @return RarUser
     */
    public function setUserAddress($userAddress)
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * Get userAddress
     *
     * @return string
     */
    public function getUserAddress()
    {
        return $this->userAddress;
    }

    /**
     * Set userZipcode
     *
     * @param string $userZipcode
     *
     * @return RarUser
     */
    public function setUserZipcode($userZipcode)
    {
        $this->userZipcode = $userZipcode;

        return $this;
    }

    /**
     * Get userZipcode
     *
     * @return string
     */
    public function getUserZipcode()
    {
        return $this->userZipcode;
    }

    /**
     * Set userCity
     *
     * @param string $userCity
     *
     * @return RarUser
     */
    public function setUserCity($userCity)
    {
        $this->userCity = $userCity;

        return $this;
    }

    /**
     * Get userCity
     *
     * @return string
     */
    public function getUserCity()
    {
        return $this->userCity;
    }

    /**
     * Set userCountry
     *
     * @param string $userCountry
     *
     * @return RarUser
     */
    public function setUserCountry($userCountry)
    {
        $this->userCountry = $userCountry;

        return $this;
    }

    /**
     * Get userCountry
     *
     * @return string
     */
    public function getUserCountry()
    {
        return $this->userCountry;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return RarUser
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set userPhone
     *
     * @param string $userPhone
     *
     * @return RarUser
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = $userPhone;

        return $this;
    }

    /**
     * Get userPhone
     *
     * @return string
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * Set userLang
     *
     * @param string $userLang
     *
     * @return RarUser
     */
    public function setUserLang($userLang)
    {
        $this->userLang = $userLang;

        return $this;
    }

    /**
     * Get userLang
     *
     * @return string
     */
    public function getUserLang()
    {
        return $this->userLang;
    }

    /**
     * Set userColor
     *
     * @param string $userColor
     *
     * @return RarUser
     */
    public function setUserColor($userColor)
    {
        $this->userColor = $userColor;

        return $this;
    }

    /**
     * Get userColor
     *
     * @return string
     */
    public function getUserColor()
    {
        return $this->userColor;
    }

    /**
     * Set userContrat
     *
     * @param integer $userContrat
     *
     * @return RarUser
     */
    public function setUserContrat($userContrat)
    {
        $this->userContrat = $userContrat;

        return $this;
    }

    /**
     * Get userContrat
     *
     * @return int
     */
    public function getUserContrat()
    {
        return $this->userContrat;
    }

    /**
     * Set userContratAmount
     *
     * @param float $userContratAmount
     *
     * @return RarUser
     */
    public function setUserContratAmount($userContratAmount)
    {
        $this->userContratAmount = $userContratAmount;

        return $this;
    }

    /**
     * Get userContratAmount
     *
     * @return float
     */
    public function getUserContratAmount()
    {
        return $this->userContratAmount;
    }

    /**
     * Set userVatnum
     *
     * @param string $userVatnum
     *
     * @return RarUser
     */
    public function setUserVatnum($userVatnum)
    {
        $this->userVatnum = $userVatnum;

        return $this;
    }

    /**
     * Get userVatnum
     *
     * @return string
     */
    public function getUserVatnum()
    {
        return $this->userVatnum;
    }
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
        
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

}

