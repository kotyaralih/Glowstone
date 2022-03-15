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

class Beetroot extends Crops
{

    protected $id = self::BEETROOT_BLOCK;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Beetroot Block";
    }

    public function getDrops(Item $item): array
    {
        $drops = [];
        if ($this->meta >= 0x07) {
            $drops[] = [Item::BEETROOT, 0, 1];
            $drops[] = [Item::BEETROOT_SEEDS, 0, mt_rand(0, 3)];
        } else {
            $drops[] = [Item::BEETROOT_SEEDS, 0, 1];
        }

        return $drops;
    }
}