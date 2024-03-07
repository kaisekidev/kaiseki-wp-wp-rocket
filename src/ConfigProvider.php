<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket;

use Kaiseki\WordPress\WpRocket\PreloadConfigurator\PreloadConfigurator;
use Kaiseki\WordPress\WpRocket\PreloadConfigurator\PreloadConfiguratorFactory;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'wp_rocket' => [
//                'preload_config' => \Kaiseki\WordPress\WpRocket\PreloadConfigurator\PreloadConfig::create()
//                    ->withBatchSize(45)
//                    ->withCronInterval(60)
//                    ->withRequestsDelay(0.5),
//                'disable_auto_purge' => \Kaiseki\WordPress\WpRocket\DisableAutoPurge\DisableAutoPurgeConfig::create()
//                    ->onTermChange()
//                    ->onRocketAfterSaveDynamicLists(),
            ],
            'hook' => [
                'provider' => [
                    PreloadConfigurator::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    PreloadConfigurator::class => PreloadConfiguratorFactory::class,
                ],
            ],
        ];
    }
}
