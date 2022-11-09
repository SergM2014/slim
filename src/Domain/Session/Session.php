<?php

declare(strict_types=1);

namespace App\Domain\Session;

use JsonSerializable;

class Session implements JsonSerializable
{
    private int $id;

    private string $sessionId;

    private string $ip;

    private string $country;

    private string $browser;

    public function __construct(int $id, string $sessionId, string $ip, string $country, $browser)
    {
        $this->id = $id;
        $this->sessionId = $sessionId;
        $this->ip = $ip;
        $this->country = ucfirst($country);
        $this->browser = $browser;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getBrowser(): string
    {
        return $this->browser;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'sessionId' => $this->sessionId,
            'ip' => $this->ip,
            'country' => $this->country,
            'browser' => $this->browser,
        ];
    }
}