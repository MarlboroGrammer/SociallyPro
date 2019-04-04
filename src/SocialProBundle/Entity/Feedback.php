<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback", indexes={@ORM\Index(name="employee_id", columns={"employee_id"}), @ORM\Index(name="manager_id", columns={"manager_id"})})
 * @ORM\Entity
 */
class Feedback
{
    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $feedbackId;

    /**
     * @var integer
     *
     * @ORM\Column(name="manager_id", type="integer", nullable=false)
     */
    private $managerId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feedback_date", type="date", nullable=false)
     */
    private $feedbackDate;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback_subject", type="string", length=50, nullable=false)
     */
    private $feedbackSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback_desc", type="text", length=65535, nullable=false)
     */
    private $feedbackDesc;

    /**
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * })
     */
    private $employee;


}

