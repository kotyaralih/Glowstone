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

namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class Skull extends Spawnable
{

    public function __construct(FullChunk $chunk, CompoundTag $nbt)
    {
        if (!isset($nbt->SkullType)) {
            $nbt->SkullType = new StringTag("SkullType", 0);
        }

        parent::__construct($chunk, $nbt);
    }

    public function saveNBT()
    {
        parent::saveNBT();
        unset($this->namedtag->Creator);
    }

    public function getSpawnCompound()
    {
        return new CompoundTag("", [
            new StringTag("id", Tile::SKULL),
            $this->namedtag->SkullType,
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z),
            $this->namedtag->Rot
        ]);
    }

    public function getSkullType()
    {
        return $this->namedtag["SkullType"];
    }
}
