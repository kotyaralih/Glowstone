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

class Dirt extends Solid
{

    protected $id = self::DIRT;

    public function __construct()
    {

    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function getHardness()
    {
        return 0.5;
    }

    public function getToolType()
    {
        return Tool::TYPE_SHOVEL;
    }

    public function getName(): string
    {
        return "Dirt";
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if ($item->isHoe()) {
            $item->useOn($this, 2);
            $this->getLevel()->setBlock($this, Block::get(Item::FARMLAND, 0), true);

            return true;
        }

        return false;
    }
}