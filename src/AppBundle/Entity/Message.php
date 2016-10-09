<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as KittyAssert;

class Message
{

    /**
     * @KittyAssert\IsNotSpam
     */
    private $message;

    /**
     * @Assert\NotBlank(message="email.blank")
     * @Assert\Email()
     */
    private $email;


    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

}
