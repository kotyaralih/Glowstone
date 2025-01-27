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
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\utils\Random;

class TallGrass
{
    public static function growGrass(ChunkManager $level, Vector3 $pos, Random $random, $count = 15, $radius = 10)
    {
        $arr = [
            [Block::DANDELION, 0],
            [Block::POPPY, 0],
            [Block::TALL_GRASS, 1],
            [Block::TALL_GRASS, 1],
            [Block::TALL_GRASS, 1],
            [Block::TALL_GRASS, 1]
        ];
        $arrC = count($arr) - 1;
        for ($c = 0; $c < $count; ++$c) {
            $x = $random->nextRange($pos->x - $radius, $pos->x + $radius);
            $z = $random->nextRange($pos->z - $radius, $pos->z + $radius);
            if ($level->getBlockIdAt($x, $pos->y + 1, $z) === Block::AIR and $level->getBlockIdAt($x, $pos->y, $z) === Block::GRASS) {
                $t = $arr[$random->nextRange(0, $arrC)];
                $level->setBlockIdAt($x, $pos->y + 1, $z, $t[0]);
                $level->setBlockDataAt($x, $pos->y + 1, $z, $t[1]);
            }
        }
    }
}