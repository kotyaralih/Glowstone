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

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class LilyPad extends Populator
{
    /** @var ChunkManager */
    private $level;
    private $randomAmount;
    private $baseAmount;

    public function setRandomAmount($amount)
    {
        $this->randomAmount = $amount;
    }

    public function setBaseAmount($amount)
    {
        $this->baseAmount = $amount;
    }

    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random)
    {
        $this->level = $level;
        $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
        for ($i = 0; $i < $amount; ++$i) {
            $x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
            $z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
            $y = $this->getHighestWorkableBlock($x, $z);

            if ($y !== -1 and $this->canLilyPadStay($x, $y, $z)) {
                $this->level->setBlockIdAt($x, $y, $z, Block::WATER_LILY);
                $this->level->setBlockDataAt($x, $y, $z, 1);
            }
        }
    }

    private function canLilyPadStay($x, $y, $z)
    {
        $b = $this->level->getBlockIdAt($x, $y, $z);
        return ($b === Block::AIR or $b === Block::SNOW_LAYER) and $this->level->getBlockIdAt($x, $y - 1, $z) === Block::STILL_WATER;
    }

    private function getHighestWorkableBlock($x, $z)
    {
        for ($y = 127; $y >= 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b !== Block::AIR and $b !== Block::LEAVES and $b !== Block::LEAVES2 and $b !== Block::SNOW_LAYER) {
                break;
            }
        }

        return $y === 0 ? -1 : ++$y;
    }
}
