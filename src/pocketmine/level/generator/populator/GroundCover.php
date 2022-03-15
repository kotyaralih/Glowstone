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
use pocketmine\level\generator\biome\Biome;
use pocketmine\level\Level;
use pocketmine\level\SimpleChunkManager;
use pocketmine\utils\Random;

class GroundCover extends Populator
{

    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random)
    {
        $chunk = $level->getChunk($chunkX, $chunkZ);
        if ($level instanceof Level or $level instanceof SimpleChunkManager) {
            $waterHeight = $level->getWaterHeight();
        } else $waterHeight = 0;
        for ($x = 0; $x < 16; ++$x) {
            for ($z = 0; $z < 16; ++$z) {
                $biome = Biome::getBiome($chunk->getBiomeId($x, $z));
                $cover = $biome->getGroundCover();
                if (count($cover) > 0) {
                    $diffY = 0;
                    if (!$cover[0]->isSolid()) {
                        $diffY = 1;
                    }

                    $column = $chunk->getBlockIdColumn($x, $z);
                    for ($y = 127; $y > 0; --$y) {
                        if ($column[$y] !== "\x00" and !Block::get(ord($column[$y]))->isTransparent()) {
                            break;
                        }
                    }
                    $startY = min(127, $y + $diffY);
                    $endY = $startY - count($cover);
                    for ($y = $startY; $y > $endY and $y >= 0; --$y) {
                        $b = $cover[$startY - $y];
                        if ($column[$y] === "\x00" and $b->isSolid()) {
                            break;
                        }
                        if ($y <= $waterHeight and $b->getId() == Block::GRASS and $chunk->getBlockId($x, $y + 1, $z) == Block::STILL_WATER) {
                            $b = Block::get(Block::DIRT);
                        }
                        if ($b->getDamage() === 0) {
                            $chunk->setBlockId($x, $y, $z, $b->getId());
                        } else {
                            $chunk->setBlock($x, $y, $z, $b->getId(), $b->getDamage());
                        }
                    }
                }
            }
        }
    }
}