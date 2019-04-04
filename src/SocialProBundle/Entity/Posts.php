<?php

namespace SocialProBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Posts
 *
 * @ORM\Table(name="posts", indexes={@ORM\Index(name="timeline_id", columns={"timeline_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="SocialProBundle\Repository\PostsRepository")
 */
class Posts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postId;

    /**
     * @var string
     *
     * @ORM\Column(name="post_content", type="text", length=65535, nullable=false)
     */
    private $postContent;

    /**
     * @ORM\Column(name="post_media", type="string")
     *
     * @Assert\NotBlank(message="Please, upload the file to join to your post")
     * @Assert\File(mimeTypes={ "application/pdf", "image/jpeg", "image/png", "image/jpeg"})
     */
    private $postMedia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_time", type="date", nullable=false)
     */
    private $postTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="post_signal", type="integer", nullable=false)
     */
    private $postSignal ;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Timeline
     *
     * @ORM\ManyToOne(targetEntity="Timeline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="timeline_id", referencedColumnName="timeline_id")
     * })
     */
    private $timeline;


    /**
     * Get postId
     *
     * @return integer
     */

    public function __construct()
    {
        $this->postTime = new \DateTime() ;
        $this->postSignal=0;
    }
    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostSignal($postSignal)
    {
        $this->postSignal = $postSignal;

        return $this;
    }

    public function getPostSignal()
    {
        return $this->postSignal;
    }

    /**
     * Set postContent
     *
     * @param string $postContent
     *
     * @return Posts
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;

        return $this;
    }

    /**
     * Get postContent
     *
     * @return string
     */
    public function getPostContent()
    {
        return $this->postContent;
    }

    /**
     * Set postMedia
     *
     * @param string $postMedia
     *
     * @return Posts
     */
    public function setPostMedia($postMedia)
    {
        $this->postMedia = $postMedia;

        return $this;
    }

    /**
     * Get postMedia
     *
     * @return string
     */
    public function getPostMedia()
    {
        return $this->postMedia;
    }

    /**
     * Set postTime
     *
     * @param \DateTime $postTime
     *
     * @return Posts
     */
    public function setPostTime($postTime)
    {
        $this->postTime = $postTime;

        return $this;
    }

    /**
     * Get postTime
     *
     * @return \DateTime
     */
    public function getPostTime()
    {
        return $this->postTime;
    }

    /**
     * Set user
     *
     * @param \SocialProBundle\Entity\FosUser $user
     *
     * @return Posts
     */
    public function setUser(\SocialProBundle\Entity\FosUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SocialProBundle\Entity\FosUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set timeline
     *
     * @param \SocialProBundle\Entity\Timeline $timeline
     *
     * @return Posts
     */
    public function setTimeline(\SocialProBundle\Entity\Timeline $timeline = null)
    {
        $this->timeline = $timeline;

        return $this;
    }

    /**
     * Get timeline
     *
     * @return \SocialProBundle\Entity\Timeline
     */
    public function getTimeline()
    {
        return $this->timeline;
    }
}
