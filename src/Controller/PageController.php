<?php

namespace App\Controller;

use App\Message\PageVisitMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PageController
{
    private LoggerInterface $logger;

    private MessageBusInterface $messageBus;

    public function __construct(LoggerInterface $logger, MessageBusInterface $messageBus)
    {
        $this->logger = $logger;
        $this->messageBus = $messageBus;
    }

    /**
     * @throws \JsonException
     */
    public function index()
    {
        $this->messageBus->dispatch(new PageVisitMessage('New Message'));
        $this->logger->debug('Page index completed');

        return json_encode('load', JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
