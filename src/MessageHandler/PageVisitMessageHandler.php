<?php

namespace App\MessageHandler;

use App\Message\PageVisitMessage;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PageVisitMessageHandler implements MessageHandlerInterface
{
    public function __invoke(PageVisitMessage $message)
    {
        $log = new Logger('PageVisit');
        $log->pushHandler(new StreamHandler(__DIR__.'/../../logs/page_visit.log', Logger::DEBUG));
        $log->info($message->getContent());
    }
}