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
use pocketmine\level\Level;

class GlowingRedstoneOre extends RedstoneOre
{

    protected $id = self::GLOWING_REDSTONE_ORE;

    public function getName(): string
    {
        return "Glowing Redstone Ore";
    }

    public function getLightLevel()
    {
        return 9;
    }

    public function onUpdate($type)
    {
        if ($type === Level::BLOCK_UPDATE_SCHEDULED or $type === Level::BLOCK_UPDATE_RANDOM) {
            $this->getLevel()->setBlock($this, Block::get(Item::REDSTONE_ORE, $this->meta), false, false);

            return Level::BLOCK_UPDATE_WEAK;
        }

        return false;
    }

}