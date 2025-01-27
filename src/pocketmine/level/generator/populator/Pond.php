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

namespace pocketmine\level\generator\populator;

use pocketmine\block\Water;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class Pond extends Populator
{
    private $waterOdd = 4;
    private $lavaOdd = 4;
    private $lavaSurfaceOdd = 4;

    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random)
    {
        if ($random->nextRange(0, $this->waterOdd) === 0) {
            $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 16);
            $y = $random->nextBoundedInt(128);
            $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 16);
            $pond = new \pocketmine\level\generator\object\Pond($random, new Water());
            if ($pond->canPlaceObject($level, $x, $y, $z)) {
                $pond->placeObject($level, $x, $y, $z);
            }
        }
    }

    public function setWaterOdd($waterOdd)
    {
        $this->waterOdd = $waterOdd;
    }

    public function setLavaOdd($lavaOdd)
    {
        $this->lavaOdd = $lavaOdd;
    }

    public function setLavaSurfaceOdd($lavaSurfaceOdd)
    {
        $this->lavaSurfaceOdd = $lavaSurfaceOdd;
    }
}