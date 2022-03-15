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


use pocketmine\level\format\FullChunk;
use pocketmine\level\Level;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;


class LightPopulationTask extends AsyncTask
{

    public $levelId;
    public $chunk;
    public $chunkClass;

    public function __construct(Level $level, FullChunk $chunk)
    {
        $this->levelId = $level->getId();
        $this->chunk = $chunk->toFastBinary();
        $this->chunkClass = get_class($chunk);
    }

    public function onRun()
    {
        /** @var FullChunk $chunk */
        $chunk = $this->chunkClass;
        $chunk = $chunk::fromFastBinary($this->chunk);
        if ($chunk === null) {
            //TODO error
            return;
        }

        $chunk->recalculateHeightMap();
        $chunk->populateSkyLight();
        $chunk->setLightPopulated();

        $this->chunk = $chunk->toFastBinary();
    }

    public function onCompletion(Server $server)
    {
        $level = $server->getLevel($this->levelId);
        if ($level !== null) {
            /** @var FullChunk $chunk */
            $chunk = $this->chunkClass;
            $chunk = $chunk::fromFastBinary($this->chunk, $level->getProvider());
            if ($chunk === null) {
                //TODO error
                return;
            }
            $level->generateChunkCallback($chunk->getX(), $chunk->getZ(), $chunk);
        }
    }
}
