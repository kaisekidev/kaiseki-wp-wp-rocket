<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\DisableAutoPurge;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_action;
use function apply_filters;
use function is_object;
use function method_exists;

final class DisableAutoPurge implements HookProviderInterface
{
    public function __construct(private readonly ?DisableAutoPurgeConfig $config = null)
    {
    }

    public function addHooks(): void
    {
        add_action('init', [$this, 'removePurgeHooks']);
    }

    public function removePurgeHooks(): void
    {
        if ($this->config === null) {
            return;
        }

        $container = apply_filters('rocket_container', '');

        if (
            !is_object($container)
            || !method_exists($container, 'get')
        ) {
            return;
        }

        $eventManager = $container->get('event_manager');
        $purgeActionsSubscriber = $container->get('purge_actions_subscriber');

        if (
            !is_object($eventManager)
            || !is_object($purgeActionsSubscriber)
            || !method_exists($eventManager, 'remove_callback')
        ) {
            return;
        }

        $config = $this->config->get();

        if ($config['change_term'] || $config['create_term']) {
            $eventManager->remove_callback('create_term', [$purgeActionsSubscriber, 'maybe_purge_cache_on_term_change']);
        }

        if ($config['change_term'] || $config['edit_term']) {
            $eventManager->remove_callback('edit_term', [$purgeActionsSubscriber, 'maybe_purge_cache_on_term_change']);
        }

        if ($config['change_term'] || $config['delete_term']) {
            $eventManager->remove_callback('delete_term', [$purgeActionsSubscriber, 'maybe_purge_cache_on_term_change']);
        }

        if ($config['rocket_after_save_dynamic_lists']) {
            $eventManager->remove_callback('rocket_after_save_dynamic_lists', [$purgeActionsSubscriber, 'purge_cache_after_saving_dynamic_lists']);
        }
    }
}
