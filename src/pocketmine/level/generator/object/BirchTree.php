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

class BirchTree extends Tree
{

    protected $superBirch = false;

    public function __construct($superBirch = false)
    {
        $this->trunkBlock = Block::LOG;
        $this->leafBlock = Block::LEAVES;
        $this->type = Wood::BIRCH;
        $this->superBirch = (bool)$superBirch;
    }

    public function placeObject(ChunkManager $level, $x, $y, $z, Random $random)
    {
        $this->treeHeight = $random->nextBoundedInt(3) + 5;
        if ($this->superBirch) {
            $this->treeHeight += 5;
        }
        parent::placeObject($level, $x, $y, $z, $random);
    }
}