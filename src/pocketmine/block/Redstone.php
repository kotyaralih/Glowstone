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

class Redstone extends RedstoneSource
{

    protected $id = self::REDSTONE_BLOCK;

    public function __construct()
    {

    }

    public function isTransparent()
    {
        return false;
    }

    public function canBeFlowedInto()
    {
        return false;
    }

    public function isSolid()
    {
        return true;
    }

    public function isActivated(Block $from = null)
    {
        return true;
    }

    public function getHardness()
    {
        return 5;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getName(): string
    {
        return "Redstone Block";
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [Item::REDSTONE_BLOCK, 0, 1],
            ];
        } else {
            return [];
        }
    }
}