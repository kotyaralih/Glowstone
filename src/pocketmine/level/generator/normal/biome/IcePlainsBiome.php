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

use pocketmine\level\generator\populator\TallGrass;

class IcePlainsBiome extends SnowyBiome
{

    public function __construct()
    {
        parent::__construct();

        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(5);

        $this->addPopulator($tallGrass);

        $this->setElevation(63, 74);

        $this->temperature = 0.05;
        $this->rainfall = 0.8;
    }

    public function getName(): string
    {
        return "Ice Plains";
    }
}