<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(name="event_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="event_name", type="string", length=50, nullable=false)
     */
    private $eventName;

    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", length=50, nullable=false)
     */
    private $eventType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="datetime", nullable=false,options={"default" : 0} )
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="event_address", type="string", length=50, nullable=false)
     */
    private $eventAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="event_description", type="text", length=65535, nullable=true)
     */
    private $eventDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="event_media", type="string", length=100, nullable=true)
     */
    private $eventMedia;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50, nullable=true,options={"default":"pending"})
     */
    private $state;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $rating;
    /**
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idEmployee;

    /**
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param \DateTime $eventDate
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return string
     */
    public function getEventAddress()
    {
        return $this->eventAddress;
    }

    /**
     * @param string $eventAddress
     */
    public function setEventAddress($eventAddress)
    {
        $this->eventAddress = $eventAddress;
    }

    /**
     * @return string
     */
    public function getEventDescription()
    {
        return $this->eventDescription;
    }

    /**
     * @param string $eventDescription
     */
    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = $eventDescription;
    }

    /**
     * @return string
     */
    public function getEventMedia()
    {
        return $this->eventMedia;
    }

    /**
     * @param string $eventMedia
     */
    public function setEventMedia($eventMedia)
    {
        $this->eventMedia = $eventMedia;
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
     * @return mixed
     */
    public function getIdEmployee()
    {
        return $this->idEmployee;
    }

    /**
     * @param mixed $idEmployee
     */
    public function setIdEmployee($FosUser)
    {
        $this->idEmployee = $FosUser;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }


}

