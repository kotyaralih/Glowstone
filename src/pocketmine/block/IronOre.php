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

use pocketmine\item\Item;
use pocketmine\item\Tool;

class IronOre extends Solid
{

    protected $id = self::IRON_ORE;

    public function __construct()
    {

    }

    public function getName(): string
    {
        return "Iron Ore";
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getHardness()
    {
        return 3;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 3) {
            return [
                [Item::IRON_ORE, 0, 1],
            ];
        } else {
            return [];
        }
    }
}