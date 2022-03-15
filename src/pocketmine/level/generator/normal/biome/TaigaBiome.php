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
use pocketmine\block\Sapling;
use pocketmine\level\generator\populator\MossStone;
use pocketmine\level\generator\populator\Tree;

class TaigaBiome extends SnowyBiome
{

    public function __construct()
    {
        parent::__construct();

        $trees = new Tree(Sapling::SPRUCE);
        $trees->setBaseAmount(10);
        $this->addPopulator($trees);

        $mossStone = new MossStone();
        $mossStone->setBaseAmount(1);

        $this->addPopulator($mossStone);

        $this->setElevation(63, 81);

        $this->temperature = 0.05;
        $this->rainfall = 0.8;

        $this->setGroundCover([
            Block::get(Block::PODZOL, 0),
            Block::get(Block::PODZOL, 0),
            Block::get(Block::MOSS_STONE, 0),
            Block::get(Block::MOSS_STONE, 0),
            Block::get(Block::MOSS_STONE, 0),
        ]);
    }

    public function getName(): string
    {
        return "Taiga";
    }
}
