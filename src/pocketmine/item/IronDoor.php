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

namespace pocketmine\item;

use pocketmine\block\Block;

class IronDoor extends Item
{
    public function __construct($meta = 0, $count = 1)
    {
        $this->block = Block::get(Item::IRON_DOOR_BLOCK);
        parent::__construct(self::IRON_DOOR, 0, $count, "Iron Door");
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }
}