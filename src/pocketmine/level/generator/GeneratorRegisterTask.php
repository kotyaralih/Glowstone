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
use pocketmine\level\generator\biome\Biome;
use pocketmine\level\Level;
use pocketmine\level\SimpleChunkManager;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Random;

class GeneratorRegisterTask extends AsyncTask
{

    public $generator;
    public $settings;
    public $seed;
    public $levelId;
    public $waterHeight;

    public function __construct(Level $level, Generator $generator)
    {
        $this->generator = get_class($generator);
        $this->waterHeight = $generator->getWaterHeight();
        $this->settings = serialize($generator->getSettings());
        $this->seed = $level->getSeed();
        $this->levelId = $level->getId();
    }

    public function onRun()
    {
        Block::init();
        Biome::init();
        $manager = new SimpleChunkManager($this->seed, $this->waterHeight);
        $this->saveToThreadStore("generation.level{$this->levelId}.manager", $manager);
        /** @var Generator $generator */
        $generator = $this->generator;
        $generator = new $generator(unserialize($this->settings));
        $generator->init($manager, new Random($manager->getSeed()));
        $this->saveToThreadStore("generation.level{$this->levelId}.generator", $generator);
    }
}
