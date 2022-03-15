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
use pocketmine\Player;

class PlayerToggleSneakEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var bool */
    protected $isSneaking;

    public function __construct(Player $player, $isSneaking)
    {
        $this->player = $player;
        $this->isSneaking = (bool)$isSneaking;
    }

    public function isSneaking()
    {
        return $this->isSneaking;
    }

}