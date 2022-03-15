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

class Carrot extends Crops
{

    protected $id = self::CARROT_BLOCK;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Carrot Block";
    }

    public function getDrops(Item $item): array
    {
        $drops = [];
        if ($this->meta >= 0x07) {
            $fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
            $fortunel = $fortunel > 3 ? 3 : $fortunel;
            $drops[] = [Item::CARROT, 0, mt_rand(1, 4 + $fortunel)];
        } else {
            $drops[] = [Item::CARROT, 0, 1];
        }
        return $drops;
    }
}
