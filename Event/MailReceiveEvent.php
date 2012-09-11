<?php

namespace Postman\PostmanBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Postman\PostmanBundle\Mail;

/**
 * @author Alexey Shockov <alexey@shockov.com>
 */
class MailReceiveEvent extends Event
{
    /**
     * @var string
     */
    private $raw;

    /**
     * @var \Postman\PostmanBundle\Mail
     */
    private $mail;

    function __construct(Mail $mail, $raw)
    {
        $this->mail = $mail;
        $this->raw = $raw;
    }

    /**
     * @return \Postman\PostmanBundle\Mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }
}
