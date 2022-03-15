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

namespace pocketmine\event\level;

use pocketmine\level\Level;
use pocketmine\level\Position;

/**
 * An event that is called when a level spawn changes.
 * The previous spawn is included
 */
class SpawnChangeEvent extends LevelEvent
{
    public static $handlerList = null;

    /** @var Position */
    private $previousSpawn;

    /**
     * @param Level $level
     * @param Position $previousSpawn
     */
    public function __construct(Level $level, Position $previousSpawn)
    {
        parent::__construct($level);
        $this->previousSpawn = $previousSpawn;
    }

    /**
     * @return Position
     */
    public function getPreviousSpawn()
    {
        return $this->previousSpawn;
    }
}