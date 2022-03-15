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
class Workbench extends Solid
{

    protected $id = self::WORKBENCH;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function getHardness()
    {
        return 2.5;
    }

    public function getName(): string
    {
        return "Crafting Table";
    }

    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if ($player instanceof Player) {
            if ($player->getServer()->limitedCreative and $player->isCreative()) return true;
            $player->craftingType = 1;
        }

        return true;
    }

    public function getDrops(Item $item): array
    {
        return [
            [$this->id, 0, 1],
        ];
    }
}