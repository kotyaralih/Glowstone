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
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\LilyPad;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\WaterPit;

class PlainBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(12);
        $waterPit = new WaterPit();
        $waterPit->setBaseAmount(9999);
        $lilyPad = new LilyPad();
        $lilyPad->setBaseAmount(8);

        $flower = new Flower();
        $flower->setBaseAmount(2);
        $flower->addType([Block::DANDELION, 0]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_POPPY]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_AZURE_BLUET]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_RED_TULIP]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_ORANGE_TULIP]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_WHITE_TULIP]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_PINK_TULIP]);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_OXEYE_DAISY]);

        $this->addPopulator($tallGrass);
        $this->addPopulator($flower);
        $this->addPopulator($waterPit);
        $this->addPopulator($lilyPad);

        $this->setElevation(61, 68);

        $this->temperature = 0.8;
        $this->rainfall = 0.4;
    }

    public function getName(): string
    {
        return "Plains";
    }
}