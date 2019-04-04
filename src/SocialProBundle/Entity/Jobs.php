<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs", uniqueConstraints={@ORM\UniqueConstraint(name="job_desc", columns={"job_desc"}), @ORM\UniqueConstraint(name="job_id", columns={"job_id"})})
 * @ORM\Entity
 */
class Jobs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_desc", type="string", length=20, nullable=false)
     */
    private $jobDesc;

    /**
     * Jobs constructor.
     * @param int $jobId
     * @param string $jobDesc
     */
    public function __construct($jobId, $jobDesc)
    {
        $this->jobId = $jobId;
        $this->jobDesc = $jobDesc;
    }

    /**
     * @return int
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param int $jobId
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * @return string
     */
    public function getJobDesc()
    {
        return $this->jobDesc;
    }

    /**
     * @param string $jobDesc
     */
    public function setJobDesc($jobDesc)
    {
        $this->jobDesc = $jobDesc;
    }

}

