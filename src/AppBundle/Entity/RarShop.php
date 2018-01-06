<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarShop
 *
 * @ORM\Table(name="rar_shop")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarShopRepository")
 */
class RarShop
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
     * @ORM\Column(name="extention", type="string", length=10)
     */
    private $extention;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=30, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_vat", type="boolean")
     */
    private $isVat;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_vat", type="float", nullable=true)
     */
    private $amountVat;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=3)
     */
    private $locale;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_eshop", type="boolean")
     */
    private $isEshop;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_directcustomer", type="boolean")
     */
    private $isDirectCustomer;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_contract", type="boolean")
     */
    private $isContract;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_contract", type="float", nullable=true)
     */
    private $amountContract;

    /**
     * @var string
     *
     * @ORM\Column(name="vat_num", type="string", length=255)
     */
    private $vatNum;

    /**
     * @ORM\OneToMany(targetEntity="RarOrder", mappedBy="shop")
     */
    protected $orders;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="shops", cascade={"persist","remove"})
     * @ORM\JoinTable(name="users_shops",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="rar_shop_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $users;

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
     * @return RarShop
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
     * Set extention
     *
     * @param string $extention
     *
     * @return RarShop
     */
    public function setExtention($extention)
    {
        $this->extention = $extention;

        return $this;
    }

    /**
     * Get extention
     *
     * @return string
     */
    public function getExtention()
    {
        return $this->extention;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return RarShop
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return RarShop
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return RarShop
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return RarShop
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set isVat
     *
     * @param boolean $isVat
     *
     * @return RarShop
     */
    public function setIsVat($isVat)
    {
        $this->isVat = $isVat;

        return $this;
    }

    /**
     * Get isVat
     *
     * @return bool
     */
    public function getIsVat()
    {
        return $this->isVat;
    }

    /**
     * Set amountVat
     *
     * @param boolean $isVat
     *
     * @return RarShop
     */
    public function setAmountVat($amountVat)
    {
        $this->amountVat = $amountVat;

        return $this;
    }

    /**
     * Get amountVat
     *
     * @return bool
     */
    public function getAmountVat()
    {
        return $this->amountVat;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RarShop
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return RarShop
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return RarShop
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set isContract
     *
     * @param boolean $isContract
     *
     * @return RarShop
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
     * Set isDirectCustomer
     *
     * @param boolean $isContract
     *
     * @return RarShop
     */
    public function setIsDirectCustomer($isDirectCustomer)
    {
        $this->isDirectCustomer = $isDirectCustomer;

        return $this;
    }

    /**
     * Get isContract
     *
     * @return bool
     */
    public function getIsDirectCustomer()
    {
        return $this->isDirectCustomer;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RarShop
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
     * Set isEshop
     *
     * @param boolean $isActive
     *
     * @return RarShop
     */
    public function setIsEshop($isEshop)
    {
        $this->isEshop = $isEshop;

        return $this;
    }

    /**
     * Get isEshop
     *
     * @return bool
     */
    public function getIsEshop()
    {
        return $this->isEshop;
    }


    /**
     * Set amountContract
     *
     * @param float $amountContract
     *
     * @return RarShop
     */
    public function setAmountContract($amountContract)
    {
        $this->amountContract = $amountContract;

        return $this;
    }

    /**
     * Get amountContract
     *
     * @return float
     */
    public function getAmountContract()
    {
        return $this->amountContract;
    }

    /**
     * Set vatNum
     *
     * @param string $vatNum
     *
     * @return RarShop
     */
    public function setVatNum($vatNum)
    {
        $this->vatNum = $vatNum;

        return $this;
    }

    /**
     * Get vatNum
     *
     * @return string
     */
    public function getVatNum()
    {
        return $this->vatNum;
    }



    /**
     * Add order
     *
     * @param \AppBundle\Entity\RarOrder $order
     *
     * @return RarShop
     */
    public function addOrder(\AppBundle\Entity\RarOrder $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\RarOrder $order
     */
    public function removeOrder(\AppBundle\Entity\RarOrder $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new ArrayCollection();
        
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RarShop
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
        $user->removeShop($this);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Remove All User
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function removeAllUsers()
    {
       $this->getUsers()->clear();
    }

    
    

}
