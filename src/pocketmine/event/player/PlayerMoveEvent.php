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

use pocketmine\event\Cancellable;
use pocketmine\level\Location;
use pocketmine\Player;

class PlayerMoveEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    private $from;
    private $to;

    public function __construct(Player $player, Location $from, Location $to)
    {
        $this->player = $player;
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom(Location $from)
    {
        $this->from = $from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo(Location $to)
    {
        $this->to = $to;
    }
}