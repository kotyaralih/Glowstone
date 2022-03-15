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

namespace pocketmine\event\player;

use pocketmine\level\Position;
use pocketmine\Player;

/**
 * Called when a player is respawned (or first time spawned)
 */
class PlayerRespawnEvent extends PlayerEvent
{
    public static $handlerList = null;

    /** @var Position */
    protected $position;

    /**
     * @param Player $player
     * @param Position $position
     */
    public function __construct(Player $player, Position $position)
    {
        $this->player = $player;
        $this->position = $position;
    }

    /**
     * @return Position
     */
    public function getRespawnPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setRespawnPosition(Position $position)
    {
        $this->position = $position;
    }
}