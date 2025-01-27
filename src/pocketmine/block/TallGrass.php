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

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\Player;

class TallGrass extends Flowable
{

    protected $id = self::TALL_GRASS;

    public function __construct($meta = 1)
    {
        $this->meta = $meta;
    }

    public function canBeReplaced()
    {
        return true;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Dead Shrub",
            1 => "Tall Grass",
            2 => "Fern",
            3 => "Unknown"
        ];
        return $names[$this->meta & 0x03];
    }

    public function getBurnChance(): int
    {
        return 60;
    }

    public function getBurnAbility(): int
    {
        return 100;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $down = $this->getSide(0);
        if ($down->getId() === self::GRASS) {
            $this->getLevel()->setBlock($block, $this, true);

            return true;
        }

        return false;
    }


    public function onUpdate($type)
    {
        if ($type === Level::BLOCK_UPDATE_NORMAL) {
            if ($this->getSide(0)->isTransparent() === true) { //Replace with common break method
                $this->getLevel()->setBlock($this, new Air(), false, false);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }

        return false;
    }

    public function getToolType()
    {
        return Tool::TYPE_SHEARS;
    }

    public function getDrops(Item $item): array
    {
        if (mt_rand(0, 15) === 0) {
            return [
                [Item::WHEAT_SEEDS, 0, 1]
            ];
        }

        return [];
    }

}
