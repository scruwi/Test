<?php

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class CsvTransport implements TransportInterface
{
    public const CONFIG_PATH = 'path';

    /** @var resource */
    private $fh;

    private LoggerInterface $logger;

    private SerializerInterface $serializer;

    public function __construct(LoggerInterface $logger, array $config)
    {
        $this->fh = fopen($config[self::CONFIG_PATH], 'ab');
        $this->logger = $logger;
        $this->serializer = new PhpSerializer();
    }

    public function get(): iterable
    {
        return fgetcsv($this->fh);
    }

    public function ack(Envelope $envelope): void
    {
        // TODO: Implement ack() method.
    }

    public function reject(Envelope $envelope): void
    {
        // TODO: Implement reject() method.
    }

    public function send(Envelope $envelope): Envelope
    {
        $uuid = md5(time());

        $encoded = $this->serializer->encode($envelope);
        $encoded['uuid'] = $uuid;
        fputcsv($this->fh, $encoded);

        $this->logger->notice("Message {$uuid} was sent successfully");

        return $envelope->with(new TransportMessageIdStamp($uuid));
    }
}
