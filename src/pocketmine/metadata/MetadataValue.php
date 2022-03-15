<?php

/**
 *
 *    ____ _                   _
 *  / ___| | _____      _____| |_ ___  _ __   ___
 * | |  _| |/ _ \ \ /\ / / __| __/ _ \| '_ \ / _ \
 * | |_| | | (_) \ V  V /\__ \ || (_) | | | |  __/
 *  \____|_|\___/ \_/\_/ |___/\__\___/|_| |_|\___|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Glowstone (Lunarelly)
 * @link https://github.com/Lunarelly
 *
 */

namespace pocketmine\metadata;

use pocketmine\plugin\Plugin;

abstract class MetadataValue
{
    /** @var \WeakRef<Plugin> */
    protected $owningPlugin;

    protected function __construct(Plugin $owningPlugin)
    {
        $this->owningPlugin = new \WeakRef($owningPlugin);
    }

    /**
     * @return Plugin
     */
    public function getOwningPlugin()
    {
        return $this->owningPlugin->get();
    }

    /**
     * Fetches the value of this metadata item.
     *
     * @return mixed
     */
    public abstract function value();

    /**
     * Invalidates this metadata item, forcing it to recompute when next
     * accessed.
     */
    public abstract function invalidate();
}