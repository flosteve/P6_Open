<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 06/03/2018
 * Time: 12:39
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

//    /**
//     * @ORM\Column(type="string", nullable=true)
//     * @Assert\NotNull(message="Tu dois choisir une congregation")
//     */
//    protected $congregation;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Task", mappedBy="users", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tasks;

    /**
     * @ORM\OneToOne(targetEntity="Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="Vous devez rentrer un code d'invitation", groups={"Registration"})
     */
    protected $invitation;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=6)
     */
    private $gender;

    /**
     * @AssertPhoneNumber(type="mobile")
     * @Assert\NotBlank()
     * @ORM\Column(type="phone_number")
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Congregation", inversedBy="members", cascade={"persist"})
     * @Assert\Valid()
     */
    private $congregation;

    public function __construct()
    {
       parent::__construct();
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCongregation()
    {
        return $this->congregation;
    }

    /**
     * @param mixed $congregation
     */
    public function setCongregation($congregation)
    {
        $this->congregation = $congregation;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add task.
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return User
     */
    public function addTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks [] = $task;

        return $this;
    }

    /**
     * @param Task $task
     */
    public function removeTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * @param Invitation $invitation
     */
    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * @return mixed
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }



}
