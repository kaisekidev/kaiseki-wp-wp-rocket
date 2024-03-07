<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\DisableAutoPurge;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class DisableAutoPurgeFactory
{
    public function __invoke(ContainerInterface $container): DisableAutoPurge
    {
        $config = Config::fromContainer($container);
        /** @var ?DisableAutoPurgeConfig $purgeConfig */
        $purgeConfig = $config->softGet('wp_rocket.disable_auto_purge');

        return new DisableAutoPurge($purgeConfig);
    }
}
