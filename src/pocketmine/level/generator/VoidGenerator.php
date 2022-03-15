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

namespace pocketmine\level\generator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\FullChunk;
use pocketmine\level\generator\biome\Biome;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class VoidGenerator extends Generator
{
    /** @var ChunkManager */
    private $level;
    /** @var FullChunk */
    private $chunk;
    /** @var Random */
    private $random;
    private $options;

    public function getSettings()
    {
        return [];
    }

    public function getName()
    {
        return "Void";
    }

    public function __construct(array $settings = [])
    {
        $this->options = $settings;
    }

    public function init(ChunkManager $level, Random $random)
    {
        $this->level = $level;
        $this->random = $random;
    }

    public function generateChunk($chunkX, $chunkZ)
    {
        $this->chunk = clone $this->level->getChunk($chunkX, $chunkZ);
        $this->chunk->setGenerated();
        $c = Biome::getBiome(1)->getColor();
        $R = $c >> 16;
        $G = ($c >> 8) & 0xff;
        $B = $c & 0xff;

        for ($Z = 0; $Z < 16; ++$Z) {
            for ($X = 0; $X < 16; ++$X) {
                $this->chunk->setBiomeId($X, $Z, 1);
                $this->chunk->setBiomeColor($X, $Z, $R, $G, $B);
                for ($y = 0; $y < 128; ++$y) {
                    $this->chunk->setBlockId($X, $y, $Z, Block::AIR);
                }
            }
        }

        $this->chunk->setBlockId(8, 64, 8, Block::GRASS);

        $chunk = clone $this->chunk;
        $chunk->setX($chunkX);
        $chunk->setZ($chunkZ);
        $this->level->setChunk($chunkX, $chunkZ, $chunk);
    }

    public function populateChunk($chunkX, $chunkZ)
    {
    }

    public function getSpawn()
    {
        return new Vector3(128, 72, 128);
    }

}
