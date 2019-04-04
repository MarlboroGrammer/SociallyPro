<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 29-Mar-17
 * Time: 2:12 PM
 */

namespace SocialProBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Complaint
 *
 * @ORM\Table(name="complaint", indexes={@ORM\Index(name="employee_complaint_fk", columns={"employee_id"})})
 * @ORM\Entity(repositoryClass="SocialProBundle\Repository\ComplaintRepository")
 */
class Complaint
{
    /**
     * @var integer
     *
     * @ORM\Column(name="complaint_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $complaintId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=20, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_complaint", type="datetime", nullable=false, options={"default": 0})
     */
    private $dateComplaint;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status = 'pending';

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=300, nullable=true)
     */
    private $answer = 'pas de reponse';

    /**
     * @var string
     *
     * @ORM\Column(name="seen", type="string", length=20, nullable=true)
     */
    private $seen = 'NULL';

    /**
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * })
     */
    private $employee;

    /**
     * @return int
     */
    public function getComplaintId()
    {
        return $this->complaintId;
    }

    /**
     * @param int $complaintId
     */
    public function setComplaintId($complaintId)
    {
        $this->complaintId = $complaintId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDateComplaint()
    {
        return $this->dateComplaint;
    }

    /**
     * @param \DateTime $dateComplaint
     */
    public function setDateComplaint($dateComplaint)
    {
        $this->dateComplaint = $dateComplaint;
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
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param string $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }

    /**
     * @return \Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \Employee $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }

}