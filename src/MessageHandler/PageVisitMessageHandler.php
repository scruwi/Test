<?php

namespace App\MessageHandler;

use App\Message\PageVisitMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PageVisitMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(PageVisitMessage $message)
    {
        $this->logger->info($message->getContent());
    }
}
