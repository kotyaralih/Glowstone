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

namespace pocketmine\level\format\anvil;

use pocketmine\level\format\LevelProvider;


class RegionLoader extends \pocketmine\level\format\mcregion\RegionLoader
{

    public function __construct(LevelProvider $level, $regionX, $regionZ)
    {
        $this->x = $regionX;
        $this->z = $regionZ;
        $this->levelProvider = $level;
        $this->filePath = $this->levelProvider->getPath() . "region/r.$regionX.$regionZ.mca";
        $exists = file_exists($this->filePath);
        touch($this->filePath);
        $this->filePointer = fopen($this->filePath, "r+b");
        stream_set_read_buffer($this->filePointer, 1024 * 16); //16KB
        stream_set_write_buffer($this->filePointer, 1024 * 16); //16KB
        if (!$exists) {
            $this->createBlank();
        } else {
            $this->loadLocationTable();
        }

        $this->lastUsed = time();
    }

    protected function unserializeChunk($data)
    {
        return Chunk::fromBinary($data, $this->levelProvider);
    }
}