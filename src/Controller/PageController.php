<?php

namespace App\Controller;

use App\Application\JsonResponse;
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

    public function index(): JsonResponse
    {
        $this->messageBus->dispatch(new PageVisitMessage('New Message'));
        $this->logger->debug('Page index completed');

        return new JsonResponse('load');
    }
}
