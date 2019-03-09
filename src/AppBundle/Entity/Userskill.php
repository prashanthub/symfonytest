<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userskill
 *
 * @ORM\Table(name="userskill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserskillRepository")
 */
class Userskill
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
     * @ORM\Column(name="skillname", type="string", length=255)
     */
    private $skillname;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="skills")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $uskill;


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
     * Set skillname
     *
     * @param string $skillname
     *
     * @return Userskill
     */
    public function setSkillname($skillname)
    {
        $this->skillname = $skillname;

        return $this;
    }

    /**
     * Get skillname
     *
     * @return string
     */
    public function getSkillname()
    {
        return $this->skillname;
    }


  

    /**
     * Set uskill
     *
     * @param \AppBundle\Entity\User $uskill
     *
     * @return Userskill
     */
    public function setUskill(\AppBundle\Entity\User $uskill = null)
    {
        $this->uskill = $uskill;

        return $this;
    }

    /**
     * Get uskill
     *
     * @return \AppBundle\Entity\User
     */
    public function getUskill()
    {
        return $this->uskill;
    }
}
