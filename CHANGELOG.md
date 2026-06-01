# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `DisableAutoPurge` hook provider — disables WP Rocket's automatic cache purging on term
  create/edit/delete and after saving dynamic lists, configured via `DisableAutoPurgeConfig`.
- `PreloadConfigurator` hook provider — overrides the preload batch size, cron interval and request
  delay via `PreloadConfig` or the `WP_ROCKET_PRELOAD_*` constants. Both wired by `ConfigProvider`.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4); now depends
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0`; removed the direct `friendsofphp/php-cs-fixer`. CI now runs via
  the reusable workflow in `kaisekidev/.github` (`coverage-threshold: 18` — only `ConfigProvider` is
  currently tested).
- Corrected the `composer.json` `license` to `MIT` to match the bundled MIT `LICENSE` file (was
  `proprietary`); set the package `description`.

### Fixed

- `DisableAutoPurgeConfig::$onRocketAfterSaveDynamicLists` now defaults to `false` — it was an
  uninitialized typed property and would error when read before the setter was called.
- Removed inline `@var` overrides in both factories: the `Config::softGet()` results are narrowed with
  `instanceof` instead. For the normal cases (a configured `*Config` object, or no value) behaviour is
  identical; a value of an unexpected type is now treated as "not configured" (`null`) rather than
  raising a `TypeError` at construction.
