<?php

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;

class SendersLocator implements SendersLocatorInterface
{
    private array $config;

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, array $config)
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    public function getSenders(Envelope $envelope): iterable
    {
        $senders = [];
        foreach ($this->config as $transportClass => $config) {
            $senders[] = new $transportClass($this->logger, $config);
        }

        return $senders;
    }
}
