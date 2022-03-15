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

class Carrot extends Food
{
    public function __construct($meta = 0, $count = 1)
    {
        $this->block = Block::get(Item::CARROT_BLOCK);
        parent::__construct(self::CARROT, 0, $count, ($meta === 1 ? "Golden " : "") . "Carrot");
    }

    public function getFoodRestore(): int
    {
        return $this->meta === 1 ? 6 : 3;
    }

    public function getSaturationRestore(): float
    {
        return $this->meta === 1 ? 14.4 : 6.8;
    }
}
