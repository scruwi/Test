<?php

namespace App\Controller;

use App\Message\PageVisitMessage;
use App\MessageHandler\PageVisitMessageHandler;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class PageController
{
    /**
     * @throws \JsonException
     */
    public function index()
    {
        $handler = new PageVisitMessageHandler();
        $bus = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                PageVisitMessage::class => [$handler],
            ])),
        ]);
        $bus->dispatch(new PageVisitMessage('New Message'));
        return json_encode('load', JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}