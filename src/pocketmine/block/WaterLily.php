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
use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\Player;

class WaterLily extends Flowable
{

    protected $id = self::WATER_LILY;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function isSolid()
    {
        return false;
    }

    public function getName(): string
    {
        return "Lily Pad";
    }

    public function getHardness()
    {
        return 0;
    }

    public function getResistance()
    {
        return 0;
    }

    public function canPassThrough()
    {
        return true;
    }

    protected function recalculateBoundingBox()
    {
        return new AxisAlignedBB(
            $this->x,
            $this->y,
            $this->z,
            $this->x,
            $this->y + 0.0625,
            $this->z
        );
    }


    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        if ($target instanceof Water) {
            $up = $target->getSide(Vector3::SIDE_UP);
            if ($up->getId() === Block::AIR) {
                $this->getLevel()->setBlock($up, $this, true, true);
                return true;
            }
        }

        return false;
    }

    public function onUpdate($type)
    {
        if ($type === Level::BLOCK_UPDATE_NORMAL) {
            if (!($this->getSide(0) instanceof Water)) {
                $this->getLevel()->useBreakOn($this);
                return Level::BLOCK_UPDATE_NORMAL;
            }
        }

        return false;
    }

    public function getDrops(Item $item): array
    {
        return [
            [$this->id, 0, 1]
        ];
    }
}