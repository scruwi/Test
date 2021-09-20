<?php

namespace App\Controller;

use App\Message\PageVisitMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class PageController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @throws \JsonException
     */
    public function index()
    {
        $this->messageBus->dispatch(new PageVisitMessage('New Message'));
        return json_encode('load', JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
