<?php

namespace App;

use App\Application\JsonResponse;
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

// Routing
$index = new PageController($logger, $bus);

try {
    $response = $index->index();
} catch (\Throwable $e) {
    $logger->error($e);
    $response = new JsonResponse('Internal server error', 500);
}

// Serialization
try {
    $content = $response->getContent();
    $contentType = 'application/json';
    $status = $response->getStatus();
} catch (\JsonException $e) {
    $content = 'Invalid json format';
    $contentType = 'text/html';
    $status = 500;
}

// Send response
http_response_code($status);
header('Content-Type: ' . $contentType);
echo $content;
