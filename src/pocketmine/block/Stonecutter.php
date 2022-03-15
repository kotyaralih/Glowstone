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
use pocketmine\Player;

//TODO: check orientation
class Stonecutter extends Solid
{

    protected $id = self::STONECUTTER;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Stonecutter";
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if ($player instanceof Player) {
            $player->craftingType = 2;
        }

        return true;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [Item::STONECUTTER, 0, 1],
            ];
        } else {
            return [];
        }
    }
}