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

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class OakTree extends Tree
{

    public function __construct()
    {
        $this->trunkBlock = Block::LOG;
        $this->leafBlock = Block::LEAVES;
        $this->type = Wood::OAK;
    }

    public function placeObject(ChunkManager $level, $x, $y, $z, Random $random)
    {
        $this->treeHeight = $random->nextBoundedInt(3) + 4;
        parent::placeObject($level, $x, $y, $z, $random);
    }
}