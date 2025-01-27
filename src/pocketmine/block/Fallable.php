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

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;

abstract class Fallable extends Solid
{

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $ret = $this->getLevel()->setBlock($this, $this, true, true);

        return $ret;
    }

    public function onUpdate($type)
    {
        if ($type === Level::BLOCK_UPDATE_NORMAL) {
            $down = $this->getSide(Vector3::SIDE_DOWN);
            if ($down->getId() === self::AIR or ($down instanceof Liquid)) {
                $fall = Entity::createEntity("FallingSand", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), new CompoundTag("", [
                    "Pos" => new ListTag("Pos", [
                        new DoubleTag("", $this->x + 0.5),
                        new DoubleTag("", $this->y),
                        new DoubleTag("", $this->z + 0.5)
                    ]),
                    "Motion" => new ListTag("Motion", [
                        new DoubleTag("", 0),
                        new DoubleTag("", 0),
                        new DoubleTag("", 0)
                    ]),
                    "Rotation" => new ListTag("Rotation", [
                        new FloatTag("", 0),
                        new FloatTag("", 0)
                    ]),
                    "TileID" => new IntTag("TileID", $this->getId()),
                    "Data" => new ByteTag("Data", $this->getDamage()),
                ]));

                $fall->spawnToAll();
            }
        }
    }
}