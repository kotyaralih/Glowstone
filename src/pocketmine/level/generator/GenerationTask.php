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
use pocketmine\level\SimpleChunkManager;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;


class GenerationTask extends AsyncTask
{

    public $state;
    public $levelId;
    public $chunk;
    public $chunkClass;

    public function __construct(Level $level, FullChunk $chunk)
    {
        $this->state = true;
        $this->levelId = $level->getId();
        $this->chunk = $chunk->toFastBinary();
        $this->chunkClass = get_class($chunk);
    }

    public function onRun()
    {
        /** @var SimpleChunkManager $manager */
        $manager = $this->getFromThreadStore("generation.level{$this->levelId}.manager");
        /** @var Generator $generator */
        $generator = $this->getFromThreadStore("generation.level{$this->levelId}.generator");
        if ($manager === null or $generator === null) {
            $this->state = false;
            return;
        }

        /** @var FullChunk $chunk */
        $chunk = $this->chunkClass;
        $chunk = $chunk::fromFastBinary($this->chunk);
        if ($chunk === null) {
            //TODO error
            return;
        }

        $manager->setChunk($chunk->getX(), $chunk->getZ(), $chunk);

        $generator->generateChunk($chunk->getX(), $chunk->getZ());

        $chunk = $manager->getChunk($chunk->getX(), $chunk->getZ());
        $chunk->setGenerated();
        $this->chunk = $chunk->toFastBinary();

        $manager->setChunk($chunk->getX(), $chunk->getZ(), null);
    }

    public function onCompletion(Server $server)
    {
        $level = $server->getLevel($this->levelId);
        if ($level !== null) {
            if ($this->state === false) {
                $level->registerGenerator();
                return;
            }
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
