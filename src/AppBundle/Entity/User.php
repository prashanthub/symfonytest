<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string")
    */
     
       protected $first_name;
     
    /**
     * @ORM\Column(type="string")
    */
     
       protected $last_name;

    /**
     * @ORM\Column(type="string")
    */
     
       protected $address;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user", cascade={"all"})
     */
       private $posts;


    /**
     * @ORM\OneToOne(targetEntity="Userinfo", cascade={"all"})
     */
      protected $userinfo;


    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_USER');
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
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
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
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
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }


    /**
     * Set userinfo
     *
     * @param \AppBundle\Entity\Userinfo $userinfo
     *
     * @return User
     */
    public function setUserinfo(\AppBundle\Entity\Userinfo $userinfo = null)
    {
        $this->userinfo = $userinfo;

        return $this;
    }

    /**
     * Get userinfo
     *
     * @return \AppBundle\Entity\Userinfo
     */
    public function getUserinfo()
    {
        return $this->userinfo;
    }
}
