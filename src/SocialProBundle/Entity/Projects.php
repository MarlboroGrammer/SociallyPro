<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projects
 *
 * @ORM\Table(name="projects", indexes={@ORM\Index(name="manager_id", columns={"manager_id"})})
 * @ORM\Entity(repositoryClass="SocialProBundle\Repository\TeamsRepository")
 */
class Projects
{
    /**
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $projectId;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=50, nullable=false)
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(name="project_desc", type="text", length=65535, nullable=false)
     */
    private $projectDesc;
    /**
    *@var
    *@ORM\Column(type="date" )
    */
    private $ProjectDate;
    /**
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * })
     */
    private $manager;

    /**
     * @return mixed
     */
    public function getProjectDate()
    {
        return $this->ProjectDate;
    }

    /**
     * @param mixed $ProjectDate
     */
    public function setProjectDate($ProjectDate)
    {
        $this->ProjectDate = $ProjectDate;
    }


    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @param string $projectName
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * @return string
     */
    public function getProjectDesc()
    {
        return $this->projectDesc;
    }

    /**
     * @param string $projectDesc
     */
    public function setProjectDesc($projectDesc)
    {
        $this->projectDesc = $projectDesc;
    }

    /**
     * @return \Employee
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param \Employee $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }


}

