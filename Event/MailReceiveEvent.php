<?php

namespace Postman\PostmanBundle\Event;

use Symfony\Component\EventDispatcher\Event;

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
     * @var \Postman\Mail
     */
    private $mail;

    function __construct(Mail $mail, $raw)
    {
        $this->mail = $mail;
        $this->raw = $raw;
    }

    /**
     * @return \Postman\Mail
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
