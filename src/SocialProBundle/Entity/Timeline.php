<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timeline
 *
 * @ORM\Table(name="timeline")
 * @ORM\Entity
 */
class Timeline
{
    /**
     * @var integer
     *
     * @ORM\Column(name="timeline_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $timelineId;


}

