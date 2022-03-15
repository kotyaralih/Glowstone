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

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerBedEnterEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    private $bed;

    public function __construct(Player $player, Block $bed)
    {
        $this->player = $player;
        $this->bed = $bed;
    }

    public function getBed()
    {
        return $this->bed;
    }

}