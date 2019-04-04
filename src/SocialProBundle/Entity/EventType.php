<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventType
 *
 * @ORM\Table(name="event_type", indexes={@ORM\Index(name="IDX_93151B8271F7E88B", columns={"event_id"})})
 * @ORM\Entity
 */
class EventType
{
    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", length=15, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $eventType;

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="event_id")
     * })
     */
    private $event;


}

