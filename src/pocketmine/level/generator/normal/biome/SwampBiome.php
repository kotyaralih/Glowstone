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

class SwampBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $flower = new Flower();
        $flower->setBaseAmount(8);
        $flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_BLUE_ORCHID]);

        $this->addPopulator($flower);

        $lilypad = new LilyPad();
        $lilypad->setBaseAmount(4);
        $this->addPopulator($lilypad);

        $this->setElevation(62, 63);

        $this->temperature = 0.8;
        $this->rainfall = 0.9;
    }

    public function getName(): string
    {
        return "Swamp";
    }

    public function getColor()
    {
        return 0x6a7039;
    }
}