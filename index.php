<?php

namespace App;

use App\Controller\PageController;
use App\Message\PageVisitMessage;
use App\MessageHandler\PageVisitMessageHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

require_once 'vendor/autoload.php';

// Init Logger
$logger = new Logger('PageVisit');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/page_visit.log', Logger::DEBUG));

// Init Messenger
$handler = new PageVisitMessageHandler($logger);
$bus = new MessageBus([
    new HandleMessageMiddleware(new HandlersLocator([
        PageVisitMessage::class => [$handler],
    ])),
]);

$index = new PageController($logger, $bus);

try {
    echo $index->index();
} catch (\JsonException | \Throwable $e) {
    $logger->error($e->getMessage());
    echo 'Internal server error';
}
