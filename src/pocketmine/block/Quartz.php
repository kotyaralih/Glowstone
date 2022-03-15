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

class Quartz extends Solid
{

    const QUARTZ_NORMAL = 0;
    const QUARTZ_CHISELED = 1;
    const QUARTZ_PILLAR = 2;
    const QUARTZ_PILLAR2 = 3;


    protected $id = self::QUARTZ_BLOCK;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 0.8;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Quartz Block",
            1 => "Chiseled Quartz Block",
            2 => "Quartz Pillar",
            3 => "Quartz Pillar",
        ];
        return $names[$this->meta & 0x03];
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [Item::QUARTZ_BLOCK, $this->meta & 0x03, 1],
            ];
        } else {
            return [];
        }
    }
}