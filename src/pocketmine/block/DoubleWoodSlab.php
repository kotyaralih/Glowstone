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

class DoubleWoodSlab extends Solid
{

    protected $id = self::DOUBLE_WOOD_SLAB;

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
        return Tool::TYPE_AXE;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Oak",
            1 => "Spruce",
            2 => "Birch",
            3 => "Jungle",
            4 => "Acacia",
            5 => "Dark Oak",
            6 => "",
            7 => ""
        ];
        return "Double " . $names[$this->meta & 0x07] . " Wooden Slab";
    }

    public function getDrops(Item $item): array
    {
        return [
            [Item::WOOD_SLAB, $this->meta & 0x07, 2],
        ];
    }

}