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

class RabbitStew extends Food
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::RABBIT_STEW, 0, $count, "Rabbit Stew");
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

    public function getFoodRestore(): int
    {
        return 10;
    }

    public function getSaturationRestore(): float
    {
        return 12;
    }

    public function getResidue()
    {
        return Item::get(Item::BOWL);
    }
}
