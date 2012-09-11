<?php

namespace Postman\PostmanBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Postman\PostmanBundle\Event\MailReceiveEvent;

/**
 * @author Alexey Shockov <alexey@shockov.com>
 */
class MailHandleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('postman:mail:handle')
            ->setDescription('Handle incoming mail');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // From pipe.
        $rawMail = stream_get_contents($this->getHelperSet()->get('dialog')->getInputStream() ?: STDIN);

        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $parser     = $this->getContainer()->get('postman.parser');

        $mail = $parser->parse($rawMail);

        $dispatcher->dispatch(
            'postman.mail.receive',
            new MailReceiveEvent($mail, $rawMail)
        );
    }
}
