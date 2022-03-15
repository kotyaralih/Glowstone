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
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;

class FlowerPot extends Spawnable
{

    public function __construct(FullChunk $chunk, CompoundTag $nbt)
    {
        parent::__construct($chunk, $nbt);
        if (!isset($nbt->item)) {
            $nbt->item = new ShortTag("item", 0);
        }
        if (!isset($nbt->mData)) {
            $nbt->mData = new IntTag("mData", 0);
        }
    }

    public function getFlowerPotItem()
    {
        return $this->namedtag["item"];
    }

    public function getFlowerPotData()
    {
        return $this->namedtag["mData"];
    }

    public function setFlowerPotData($item, $data)
    {
        $this->namedtag->item = new ShortTag("item", (int)$item);
        $this->namedtag->mData = new IntTag("mData", (int)$data);
        $this->spawnToAll();
        if ($this->chunk) {
            $this->chunk->setChanged();
            $this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
        }
        return true;
    }

    public function getSpawnCompound()
    {
        return new CompoundTag("", [
            new StringTag("id", Tile::FLOWER_POT),
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z),
            new ShortTag("item", (int)$this->namedtag["item"]),
            new IntTag("mData", (int)$this->namedtag["mData"])
        ]);
    }
}