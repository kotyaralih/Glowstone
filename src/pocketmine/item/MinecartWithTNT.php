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

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\MinecartTNT;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;

class MinecartWithTNT extends Item
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::MINECART_WITH_TNT, $meta, $count, "Minecart with TNT");
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz)
    {
        $minecartTnt = new MinecartTNT($player->getLevel()->getChunk($block->getX() >> 4, $block->getZ() >> 4), new CompoundTag("", [
            "Pos" => new ListTag("Pos", [
                new DoubleTag("", $block->getX()),
                new DoubleTag("", $block->getY() + 0.8),
                new DoubleTag("", $block->getZ())
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
        ]));
        $minecartTnt->spawnToAll();

        if ($player->isSurvival()) {
            $item = $player->getInventory()->getItemInHand();
            $count = $item->getCount();
            if (--$count <= 0) {
                $player->getInventory()->setItemInHand(Item::get(Item::AIR));
                return true;
            }

            $item->setCount($count);
            $player->getInventory()->setItemInHand($item);
        }

        return true;
    }
}