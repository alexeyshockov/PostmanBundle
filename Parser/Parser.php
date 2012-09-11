<?php

namespace Postman\PostmanBundle\Parser;

use Postman\PostmanBundle\Mail;

/**
 * @author Alexey Shockov <alexey@shockov.com>
 */
class Parser implements ParserInterface
{
    /**
     * @param string $mail Raw mail string.
     *
     * @return \Postman\PostmanBundle\Mail
     */
    public function parse($mail)
    {
        $parser = new \ezcMailParser();

        $mails = $parser->parseMail(new \ezcMailVariableSet($mail));

        $mail = array_shift($mails);

        // TODO Parse text/html to text...
        $plainPart = null;
        if ($mail->body instanceof \ezcMailMultipartAlternative) {
            foreach ($mail->body->getParts() as $part) {
                if ('plain' == $part->subType) {
                    $plainPart = $part;
                }
            }
        } else {
            $plainPart = $mail->body;
        }

        if (empty($mail->from) || empty($mail->to)) {
            throw new \InvalidArgumentException('Unable to parse message.');
        }

        $visibleFragments = \EmailReplyParser\EmailReplyParser::read($plainPart->text);

        $visibleFragments = to_collection($visibleFragments)
            ->rejectBy(x()->isHidden())
            ->rejectBy(x()->isQuoted())
            ->toArray();

        $text = implode("\n", $visibleFragments);

        $text = rtrim($text);

        return new Mail(
            $mail->from,
            $mail->to[0],
            $mail->subject,
            $text
        );
    }
}
