<?php

namespace Postman\PostmanBundle\Parser;

/**
 * @author Alexey Shockov <alexey@shockov.com>
 */
interface ParserInterface
{
    /**
     * @param string $mail Raw mail string.
     *
     * @return \Postman\PostmanBundle\Mail
     */
    function parse($mail);
}
