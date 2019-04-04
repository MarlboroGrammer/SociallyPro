<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tasks
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity
 */
class Tasks
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="task_name", type="string", length=50, nullable=false)
     */
    private $taskName;

    /**
     * @var string
     *
     * @ORM\Column(name="task_priority", type="string", length=6, nullable=false)
     */
    private $taskPriority;

    /**
     * @var string
     * @ORM\Column(name="Status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Projects")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="project_id")
     */

    private $projetcs;

    /**
     * @ORM\ManyToOne(targetEntity="FosUser")
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * @param string $taskName
     */
    public function setTaskName($taskName)
    {
        $this->taskName = $taskName;
    }

    /**
     * @return string
     */
    public function getTaskPriority()
    {
        return $this->taskPriority;
    }

    /**
     * @param string $taskPriority
     */
    public function setTaskPriority($taskPriority)
    {
        $this->taskPriority = $taskPriority;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProjetcs()
    {
        return $this->projetcs;
    }

    /**
     * @param mixed $projetcs
     */
    public function setProjetcs($projetcs)
    {
        $this->projetcs = $projetcs;
    }





}


