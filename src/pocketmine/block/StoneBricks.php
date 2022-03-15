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

class StoneBricks extends Solid
{

    const NORMAL = 0;
    const MOSSY = 1;
    const CRACKED = 2;
    const CHISELED = 3;

    protected $id = self::STONE_BRICKS;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 1.5;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Stone Bricks",
            1 => "Mossy Stone Bricks",
            2 => "Cracked Stone Bricks",
            3 => "Chiseled Stone Bricks",
        ];
        return $names[(int)$this->meta & 0x03];
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [Item::STONE_BRICKS, $this->meta & 0x03, 1],
            ];
        } else {
            return [];
        }
    }

}