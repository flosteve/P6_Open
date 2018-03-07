<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 06/03/2018
 * Time: 12:39
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
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

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $congregation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Task", inversedBy="users", cascade={"persist"})
     */
    private $task;


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

}