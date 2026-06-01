# kaiseki/wp-wp-rocket

Configure WP Rocket: disable automatic cache purging on term changes and tune cache preloading.

Two `kaiseki/wp-hook` `HookProviderInterface`s wired through `ConfigProvider`, both no-ops unless
configured (and unless WP Rocket is active):

- **`DisableAutoPurge`** — stops WP Rocket from purging the cache on term create/edit/delete and after
  saving dynamic lists.
- **`PreloadConfigurator`** — overrides the preload batch size, cron interval and delay between
  requests (config values, or the `WP_ROCKET_PRELOAD_*` constants if defined).

## Installation

```bash
composer require kaiseki/wp-wp-rocket
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator, configure the `wp_rocket` key with
the fluent config objects, and activate the providers via `kaiseki/wp-hook`:

```php
use Kaiseki\WordPress\WpRocket\DisableAutoPurge\DisableAutoPurge;
use Kaiseki\WordPress\WpRocket\DisableAutoPurge\DisableAutoPurgeConfig;
use Kaiseki\WordPress\WpRocket\PreloadConfigurator\PreloadConfigurator;
use Kaiseki\WordPress\WpRocket\PreloadConfigurator\PreloadConfig;

return [
    'wp_rocket' => [
        'preload_config' => PreloadConfig::create()
            ->withBatchSize(45)
            ->withCronInterval(60)
            ->withRequestsDelay(0.5),
        'disable_auto_purge' => DisableAutoPurgeConfig::create()
            ->onTermChange()
            ->onRocketAfterSaveDynamicLists(),
    ],
    'hook' => [
        'provider' => [
            DisableAutoPurge::class,
            PreloadConfigurator::class,
        ],
    ],
];
```

`ConfigProvider` registers a factory for each provider; each reads its `wp_rocket.*` config object from
the container and is inert when that config is absent.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE).
