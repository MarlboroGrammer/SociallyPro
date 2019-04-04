<?php
/**
 * Created by PhpStorm.
 * User: salah
 * Date: 4/9/2017
 * Time: 6:06 PM
 */

namespace SocialProBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MarketChat
 * @package SocialProBundle\Entity
 * @ORM\Table(name="market_chat")
 * @ORM\Entity()
 */
class MarketChat{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\Column(name="message", type="string", length=50)
     */
    private $message;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


}