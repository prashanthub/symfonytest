<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userinfo
 *
 * @ORM\Table(name="userinfo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserinfoRepository")
 */
class Userinfo
{

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    protected $phonenumber;


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
     * Set phonenumber
     *
     * @param integer $phonenumber
     *
     * @return Userinfo
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return integer
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
}
