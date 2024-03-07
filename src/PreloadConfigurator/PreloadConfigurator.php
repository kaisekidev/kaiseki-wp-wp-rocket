<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\PreloadConfigurator;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_filter;
use function defined;
use function is_numeric;

final class PreloadConfigurator implements HookProviderInterface
{
    private ?int $batchSize = null;
    private ?int $cronInterval = null;
    private ?float $requestsDelay = null;

    public function __construct(?PreloadConfig $config = null)
    {
        if ($config !== null) {
            $this->batchSize = $config->get()['batch_size'];
            $this->cronInterval = $config->get()['cron_interval'];
            $this->requestsDelay = $config->get()['requests_delay'];
        }
    }

    public function addHooks(): void
    {
        add_filter('rocket_preload_cache_pending_jobs_cron_rows_count', [$this, 'preloadBatchSize']);
        add_filter('rocket_preload_pending_jobs_cron_interval', [$this, 'preloadCronInterval']);
        add_filter('rocket_preload_delay_between_requests', [$this, 'preloadRequestsDelay']);
    }

    /**
     *  1) BATCH SIZE
     *  Change the number of URLs to preload on each batch, 45 is the default.
     *  A lower value can help the server to work on fewer requests at a time
     *
     * @param int $batchSize
     */
    public function preloadBatchSize(int $batchSize): int
    {
        if (
            defined('WP_ROCKET_PRELOAD_BATCH_SIZE')
            && is_numeric(WP_ROCKET_PRELOAD_BATCH_SIZE)
            && (int)WP_ROCKET_PRELOAD_BATCH_SIZE > 0
        ) {
            return (int)WP_ROCKET_PRELOAD_BATCH_SIZE;
        }

        if ($this->batchSize !== null && $this->batchSize > 0) {
            return $this->batchSize;
        }

        return $batchSize;
    }

    /**
     *  2) CRON INTERVAL:
     *  Set the desired cron interval in seconds, 60 is the default
     *  By setting a higher value the server will have more time to rest between processing batches.
     *
     * @param int $interval
     */
    public function preloadCronInterval(int $interval): int
    {
        if (
            defined('WP_ROCKET_PRELOAD_INTERVAL')
            && is_numeric(WP_ROCKET_PRELOAD_INTERVAL)
            && (int)WP_ROCKET_PRELOAD_INTERVAL > 0
        ) {
            return (int)WP_ROCKET_PRELOAD_INTERVAL;
        }

        if ($this->cronInterval !== null && $this->cronInterval > 0) {
            return $this->cronInterval;
        }

        return $interval;
    }

    /**
     *  3) DELAY BETWEEN REQUESTS:
     *  This is the delay between requests. A higher delay will reduce the CPU usage.
     *  Default is 0.5 seconds (500000 microseconds)
     *
     * @param float|int $delayBetween
     */
    public function preloadRequestsDelay(int|float $delayBetween): int|float
    {
        if (
            defined('WP_ROCKET_PRELOAD_REQUEST_DELAY')
            && is_numeric(WP_ROCKET_PRELOAD_REQUEST_DELAY)
            && (float)WP_ROCKET_PRELOAD_REQUEST_DELAY > 0
        ) {
            return (float)WP_ROCKET_PRELOAD_REQUEST_DELAY * 1000000;
        }

        if ($this->requestsDelay !== null && $this->requestsDelay > 0) {
            return $this->requestsDelay * 1000000;
        }

        return $delayBetween;
    }
}
