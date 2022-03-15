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

class Comparator extends RedstoneSource
{
    protected $id = self::UNPOWERED_COMPORATOR;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Comparator";
    }

    public function getStrength()
    {
        return 15;
    }

    public function isActivated(Block $from = null)
    {
        return false;
    }

    public function onBreak(Item $item)
    {
        $this->getLevel()->setBlock($this, new Air(), true);
    }

    public function getDrops(Item $item): array
    {
        return [
            [Item::COMPARATOR, 0, 1]
        ];
    }
}