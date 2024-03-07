<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\WpRocket\DisableAutoPurge;

final class DisableAutoPurgeConfig
{
    private bool $onTermChange = false;
    private bool $onTermCreate = false;
    private bool $onTermEdit = false;
    private bool $onTermDelete = false;
    private bool $onRocketAfterSaveDynamicLists;

    public static function create(): self
    {
        return new self();
    }

    /**
     * @return array<string, bool>
     */
    public function get(): array
    {
        return [
            'change_term' => $this->onTermChange,
            'create_term' => $this->onTermCreate,
            'edit_term' => $this->onTermEdit,
            'delete_term' => $this->onTermDelete,
            'rocket_after_save_dynamic_lists' => $this->onRocketAfterSaveDynamicLists,
        ];
    }

    public function onTermChange(bool $value = true): self
    {
        $this->onTermChange = $value;

        return $this;
    }

    public function onTermCreate(bool $value = true): self
    {
        $this->onTermCreate = $value;

        return $this;
    }

    public function onTermEdit(bool $value = true): self
    {
        $this->onTermEdit = $value;

        return $this;
    }

    public function onTermDelete(bool $value = true): self
    {
        $this->onTermDelete = $value;

        return $this;
    }

    public function onRocketAfterSaveDynamicLists(bool $value = true): self
    {
        $this->onRocketAfterSaveDynamicLists = $value;

        return $this;
    }
}
