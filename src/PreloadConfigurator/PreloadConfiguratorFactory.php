<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\PreloadConfigurator;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class PreloadConfiguratorFactory
{
    public function __invoke(ContainerInterface $container): PreloadConfigurator
    {
        $config = Config::fromContainer($container);
        /** @var ?PreloadConfig $preloadConfig */
        $preloadConfig = $config->softGet('wp_rocket.preload_config');

        return new PreloadConfigurator($preloadConfig);
    }
}
