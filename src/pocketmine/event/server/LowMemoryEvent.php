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

namespace pocketmine\event\server;

use pocketmine\utils\Utils;


/**
 * Called when the server is in a low-memory state as defined by the properties
 * Plugins should free caches or other non-essential data.
 */
class LowMemoryEvent extends ServerEvent
{
    public static $handlerList = null;

    private $memory;
    private $memoryLimit;
    private $triggerCount;
    private $global;

    public function __construct($memory, $memoryLimit, $isGlobal = false, $triggerCount = 0)
    {
        $this->memory = $memory;
        $this->memoryLimit = $memoryLimit;
        $this->global = (bool)$isGlobal;
        $this->triggerCount = (int)$triggerCount;
    }

    /**
     * Returns the memory usage at the time of the event call (in bytes)
     *
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Returns the memory limit defined (in bytes)
     *
     * @return int
     */
    public function getMemoryLimit()
    {
        return $this->memory;
    }

    /**
     * Returns the times this event has been called in the current low-memory state
     *
     * @return int
     */
    public function getTriggerCount()
    {
        return $this->triggerCount;
    }

    /**
     * @return bool
     */
    public function isGlobal()
    {
        return $this->global;
    }

    /**
     * Amount of memory already freed
     *
     * @return int
     */
    public function getMemoryFreed()
    {
        return $this->getMemory() - ($this->isGlobal() ? Utils::getMemoryUsage(true)[1] : Utils::getMemoryUsage(true)[0]);
    }

}