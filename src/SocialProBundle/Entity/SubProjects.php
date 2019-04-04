<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubProjects
 *
 * @ORM\Table(name="sub_projects", indexes={@ORM\Index(name="project_id", columns={"project_id"}), @ORM\Index(name="team_id", columns={"team_id"})})
 * @ORM\Entity(repositoryClass="SocialProBundle\Repository\TeamsRepository")
 */
class SubProjects
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sub_project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $subProjectId;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_project_name", type="string", length=50, nullable=false)
     */
    private $subProjectName;

    /**
     * @var \Projects
     *
     * @ORM\ManyToOne(targetEntity="Projects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="project_id")
     * })
     */
    private $project;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * })
     */
    private $team;

    /**
     * @return int
     */
    public function getSubProjectId()
    {
        return $this->subProjectId;
    }

    /**
     * @param int $subProjectId
     */
    public function setSubProjectId($subProjectId)
    {
        $this->subProjectId = $subProjectId;
    }

    /**
     * @return string
     */
    public function getSubProjectName()
    {
        return $this->subProjectName;
    }

    /**
     * @param string $subProjectName
     */
    public function setSubProjectName($subProjectName)
    {
        $this->subProjectName = $subProjectName;
    }

    /**
     * @return \Projects
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \Projects $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return \Teams
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param \Teams $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }


}

