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

class CookedFish extends Fish
{
    public function __construct($meta = 0, $count = 1)
    {
        Food::__construct(self::COOKED_FISH, $meta, $count, $meta === self::FISH_SALMON ? "Cooked Salmon" : "Cooked Fish");
    }

    public function getFoodRestore(): int
    {
        return $this->meta === self::FISH_SALMON ? 6 : 5;
    }

    public function getSaturationRestore(): float
    {
        return $this->meta === self::FISH_SALMON ? 9.6 : 6;
    }
}
