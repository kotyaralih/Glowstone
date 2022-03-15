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
use pocketmine\item\Tool;

class NetherQuartzOre extends Solid
{
    protected $id = self::NETHER_QUARTZ_ORE;

    public function __construct()
    {

    }

    public function getName(): string
    {
        return "Nether Quartz Ore";
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getHardness()
    {
        return 3;
    }

    public function getResistance()
    {
        return 15;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= Tool::TIER_WOODEN) {
            if ($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0) {
                return [
                    [Item::NETHER_QUARTZ_ORE, 0, 1],
                ];
            } else {
                $fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
                $fortunel = $fortunel > 3 ? 3 : $fortunel;
                $times = [1, 1, 2, 3, 4];
                $time = $times[mt_rand(0, $fortunel + 1)];
                return [
                    [Item::NETHER_QUARTZ, 0, $time],
                ];
            }
        } else {
            return [];
        }
    }
}
