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
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\protocol\BlockEntityDataPacket;
use pocketmine\Player;

abstract class Spawnable extends Tile
{

    public function spawnTo(Player $player)
    {
        if ($this->closed) {
            return false;
        }

        $nbt = new NBT(NBT::LITTLE_ENDIAN);
        $nbt->setData($this->getSpawnCompound());
        $pk = new BlockEntityDataPacket();
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->namedtag = $nbt->write();
        $player->dataPacket($pk);

        return true;
    }

    /**
     * @return CompoundTag
     */
    public abstract function getSpawnCompound();

    public function __construct(FullChunk $chunk, CompoundTag $nbt)
    {
        parent::__construct($chunk, $nbt);
        $this->spawnToAll();
    }

    public function spawnToAll()
    {
        if ($this->closed) {
            return;
        }

        foreach ($this->getLevel()->getChunkPlayers($this->chunk->getX(), $this->chunk->getZ()) as $player) {
            if ($player->spawned === true) {
                $this->spawnTo($player);
            }
        }
    }
}