<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\PreloadConfigurator;

final class PreloadConfig
{
    private ?int $batchSize = null;
    private ?int $cronInterval = null;
    private ?float $requestsDelay = null;

    public static function create(): self
    {
        return new self();
    }

    /**
     * @return array{batch_size: ?int, cron_interval: ?int, requests_delay: ?float}
     */
    public function get(): array
    {
        return [
            'batch_size' => $this->batchSize,
            'cron_interval' => $this->cronInterval,
            'requests_delay' => $this->requestsDelay,
        ];
    }

    public function withBatchSize(int $value): self
    {
        $this->batchSize = $value;

        return $this;
    }

    public function withCronInterval(int $value): self
    {
        $this->cronInterval = $value;

        return $this;
    }

    public function withRequestsDelay(float $value): self
    {
        $this->requestsDelay = $value;

        return $this;
    }
}
