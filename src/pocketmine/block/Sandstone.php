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

class Sandstone extends Solid
{

    const NORMAL = 0;
    const CHISELED = 1;
    const SMOOTH = 2;

    protected $id = self::SANDSTONE;

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
            0 => "Sandstone",
            1 => "Chiseled Sandstone",
            2 => "Smooth Sandstone",
            3 => "",
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
                [$this->id, $this->meta & 0x03, 1],
            ];
        } else {
            return [];
        }
    }

}