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

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;
use pocketmine\level\generator\populator\Cactus;
use pocketmine\level\generator\populator\DeadBush;
use pocketmine\level\generator\populator\TallCacti;

class SandyBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $cactus = new Cactus();
        $cactus->setBaseAmount(2);
        $tallCacti = new TallCacti();
        $tallCacti->setBaseAmount(60);
        $deadBush = new DeadBush();
        $deadBush->setBaseAmount(2);

        $this->addPopulator($cactus);
        $this->addPopulator($tallCacti);
        $this->addPopulator($deadBush);

        $this->setElevation(63, 81);

        $this->temperature = 0.05;
        $this->rainfall = 0.8;
        $this->setGroundCover([
            Block::get(Block::SAND, 0),
            Block::get(Block::SAND, 0),
            Block::get(Block::SAND, 0),
            Block::get(Block::SANDSTONE, 0),
            Block::get(Block::SANDSTONE, 0),
        ]);
    }

    public function getName(): string
    {
        return "Sandy";
    }
}
