<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idParticipant", columns={"idParticipant"}), @ORM\Index(name="idEvent", columns={"idEvent"})})
 * @ORM\Entity
 */
class Participation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="participation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $participationId;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", nullable=false)
     */
    private $state ;

    /**
     * @var string
     *
     * @ORM\Column(name="justification", type="string", length=200, nullable=true)
     */
    private $justification;

    /**
     * @var \FosUser
  n    *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idParticipant", referencedColumnName="id")
     * })
     */
    private $idparticipant;


    /**
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvent", referencedColumnName="event_id")
     * })
     */
    private $idevent;

    /**
     * @return int
     */
    public function getParticipationId()
    {
        return $this->participationId;
    }

    /**
     * @param int $participationId
     */
    public function setParticipationId($participationId)
    {
        $this->participationId = $participationId;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getJustification()
    {
        return $this->justification;
    }

    /**
     * @param string $justification
     */
    public function setJustification($justification)
    {
        $this->justification = $justification;
    }

    /**
     * @return \FosUser
     */
    public function getIdparticipant()
    {
        return $this->idparticipant;
    }

    /**
     * @param \FosUser $idparticipant
     */
    public function setIdparticipant($idparticipant)
    {
        $this->idparticipant = $idparticipant;
    }

    /**
     * @return \Events
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param \Events $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }


}

