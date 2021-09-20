<?php

namespace App\Application;

class JsonResponse
{
    /** @var mixed */
    private $body;

    private int $status;

    public function __construct($body, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     * @throws \JsonException
     */
    public function getContent(): string
    {
        return \json_encode($this->body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
