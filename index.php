<?php

namespace App;

use App\Controller\PageController;
use App\Message\PageVisitMessage;
use App\MessageHandler\PageVisitMessageHandler;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

require_once 'vendor/autoload.php';

// Init Messenger
$handler = new PageVisitMessageHandler();
$bus = new MessageBus([
    new HandleMessageMiddleware(new HandlersLocator([
        PageVisitMessage::class => [$handler],
    ])),
]);

$index = new PageController($bus);

try {
    echo $index->index();
} catch (\JsonException $e) {
}
