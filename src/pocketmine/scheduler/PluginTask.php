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

namespace pocketmine\scheduler;

use pocketmine\plugin\Plugin;

/**
 * Base class for plugin tasks. Allows the Server to delete them easily when needed
 */
abstract class PluginTask extends Task
{

    /** @var Plugin */
    protected $owner;

    /**
     * @param Plugin $owner
     */
    public function __construct(Plugin $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return Plugin
     */
    public final function getOwner()
    {
        return $this->owner;
    }

}
