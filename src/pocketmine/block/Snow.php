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

namespace pocketmine\block;

use pocketmine\item\enchantment\enchantment;
use pocketmine\item\Item;

class Snow extends Solid
{

    protected $id = self::SNOW_BLOCK;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 0.2;
    }

    public function getName(): string
    {
        return "Snow Block";
    }

    public function getDrops(Item $item): array
    {
        if ($item->isShovel() !== false) {
            if ($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0) {
                return [
                    [Item::SNOW_BLOCK, 0, 1],
                ];
            } else {
                return [
                    [Item::SNOWBALL, 0, 4],
                ];
            }
        } else {
            return [];
        }
    }
}
