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

class DoubleSlab extends Solid
{

    protected $id = self::DOUBLE_SLAB;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 2;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Stone",
            1 => "Sandstone",
            2 => "Wooden",
            3 => "Cobblestone",
            4 => "Brick",
            5 => "Stone Brick",
            6 => "Quartz",
            7 => "Nether Brick",
        ];
        return "Double " . $names[$this->meta & 0x07] . " Slab";
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [Item::SLAB, $this->meta & 0x07, 2],
            ];
        } else {
            return [];
        }
    }

}