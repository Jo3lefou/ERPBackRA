<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="role", type="string", length=60)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="user_color", type="string", length=7)
     */
    private $userColor;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=127)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=127)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=100)
     */
    private $locale;

    /**
     * @var bool
     *
     * @ORM\Column(name="customer_allow", type="boolean")
     */
    private $customerAllow;

    /**
     * Many Users have One Providers.
     * @ORM\ManyToOne(targetEntity="RarProvider", inversedBy="providers")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id")
     */
    protected $provider;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="image_file", type="string", length=255, nullable=true)
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255, nullable=true)
     */
    private $imagePath;

    /**
     * @ORM\OneToMany(targetEntity="RarOrder", mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity="RarShop", inversedBy="users", cascade={"persist","remove"})
     * @ORM\JoinTable(name="users_shops")
     */
    protected $shops;

    /**
     * @ORM\ManyToMany(targetEntity="RarWorkroom", inversedBy="users", cascade={"persist","remove"})
     * @ORM\JoinTable(name="users_workrooms")
     */
    protected $workrooms;
    
    /**
     * @ORM\ManyToOne(targetEntity="RarConfiguration", inversedBy="users")
     * @ORM\JoinColumn(name="configuration_id", referencedColumnName="id")
     */
    protected $configuration;

    /**
     * @ORM\OneToMany(targetEntity="RarStockLog", mappedBy="user")
     */
    private $stockLogs;

    /**
     * @ORM\OneToMany(targetEntity="RarMeeting", mappedBy="user", cascade="persist")
     */
    protected $meetings;

    /**
     * @ORM\OneToMany(targetEntity="RarMeeting", mappedBy="sale", cascade="persist")
     */
    protected $sales;

    /**
     * @ORM\OneToMany(targetEntity="RarOrderNotes", mappedBy="user",cascade={"persist"})
     */
    private $orderNotes;

    /**
     * @ORM\OneToMany(targetEntity="RarOrderLog", mappedBy="user",cascade={"persist"})
     */
    private $orderLogs;

    /**
     * @ORM\OneToMany(targetEntity="RarPayment", mappedBy="user",cascade={"persist"})
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity="RarNotes", mappedBy="user",cascade={"persist"})
     */
    private $notes;


    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getMobile()
    {
        return $this->mobile;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getCountry()
    {
        return $this->country;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function setUserColor($userColor)
    {
        $this->userColor = $userColor;
        return $this;
    }

    public function getUserColor()
    {
        return $this->userColor;
    }

    public function eraseCredentials()
    {
    }
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
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
            $this->isActive
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
            $this->isActive

        ) = unserialize($serialized);
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return User
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * Get imageFile
     *
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }
    /**
     * Set state
     *
     * @param string $state
     *
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Set imageFile
     *
     * @param string $imageFile
     *
     */
    public function setImageFile($imageFile)
    {
        if( $imageFile ){
            $this->$imageFile = $imageFile;
            return $this;
        }
    }

    /**
     * Set customerAllow
     *
     * @param boolean $customerAllow
     *
     * @return RarCustomer
     */
    public function setCustomerAllow($customerAllow)
    {
        $this->customerAllow = $customerAllow;

        return $this;
    }

    /**
     * Get customerAllow
     *
     * @return bool
     */
    public function getCustomerAllow()
    {
        return $this->customerAllow;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->workrooms = new ArrayCollection();
        $this->shops = new ArrayCollection();
        
    }

    /***** SHOP *****/
    
    /**
     * Add shop
     *
     * @param \AppBundle\Entity\RarShop $shop
     *
     * @return User
     */
    public function addShop(\AppBundle\Entity\RarShop $shop)
    {
        $this->shops[] = $shop;
        return $this;
    }

    /**
     * Remove shop
     *
     * @param \AppBundle\Entity\RarShop $shop
     */
    public function removeShop(\AppBundle\Entity\RarShop $shop)
    {
        $this->shops->removeElement($shop);
    }

    /**
     * Get shops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShops()
    {
        return $this->shops;
    }

    /***** WORKROOM *****/

    /**
     * Add workroom
     *
     * @param \AppBundle\Entity\RarWorkroom $workroom
     *
     * @return User
     */
    public function addWorkroom(\AppBundle\Entity\RarWorkroom $workroom)
    {
        $this->workrooms[] = $workroom;
        return $this;
    }

    /**
     * Remove workroom
     *
     * @param \AppBundle\Entity\RarWorkroom $workroom
     */
    public function removeWorkroom(\AppBundle\Entity\RarWorkroom $workroom)
    {
        $this->workrooms->removeElement($workroom);
    }

    /**
     * Get workrooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkrooms()
    {
        return $this->workrooms;
    }
    
    /**
     * Set provider
     *
     * @param \AppBundle\Entity\RarProvider $provider
     *
     * @return User
     */
    public function setProvider(\AppBundle\Entity\RarProvider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \AppBundle\Entity\RarProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\RarOrder $order
     *
     * @return User
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
     * Set configuration
     *
     * @param \AppBundle\Entity\RarConfiguration $configuration
     *
     * @return RarOrder
     */
    public function setConfiguration(\AppBundle\Entity\RarConfiguration $configuration = null)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return \AppBundle\Entity\RarConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
