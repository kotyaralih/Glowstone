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
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

abstract class Stair extends Transparent
{

    /*
    public function collidesWithBB(AxisAlignedBB $bb, &$list = []){
        $damage = $this->getDamage();
        $j = $damage & 0x03;

        $f = 0;
        $f1 = 0.5;
        $f2 = 0.5;
        $f3 = 1;

        if(($damage & 0x04) > 0){
            $f = 0.5;
            $f1 = 1;
            $f2 = 0;
            $f3 = 0.5;
        }

        if($bb->intersectsWith($bb2 = AxisAlignedBB::getBoundingBoxFromPool(
            $this->x,
            $this->y + $f,
            $this->z,
            $this->x + 1,
            $this->y + $f1,
            $this->z + 1
        ))){
            $list[] = $bb2;
        }

        if($j === 0){
            if($bb->intersectsWith($bb2 = AxisAlignedBB::getBoundingBoxFromPool(
                $this->x + 0.5,
                $this->y + $f2,
                $this->z,
                $this->x + 1,
                $this->y + $f3,
                $this->z + 1
            ))){
                $list[] = $bb2;
            }
        }elseif($j === 1){
            if($bb->intersectsWith($bb2 = AxisAlignedBB::getBoundingBoxFromPool(
                $this->x,
                $this->y + $f2,
                $this->z,
                $this->x + 0.5,
                $this->y + $f3,
                $this->z + 1
            ))){
                $list[] = $bb2;
            }
        }elseif($j === 2){
            if($bb->intersectsWith($bb2 = AxisAlignedBB::getBoundingBoxFromPool(
                $this->x,
                $this->y + $f2,
                $this->z + 0.5,
                $this->x + 1,
                $this->y + $f3,
                $this->z + 1
            ))){
                $list[] = $bb2;
            }
        }elseif($j === 3){
            if($bb->intersectsWith($bb2 = AxisAlignedBB::getBoundingBoxFromPool(
                $this->x,
                $this->y + $f2,
                $this->z,
                $this->x + 1,
                $this->y + $f3,
                $this->z + 0.5
            ))){
                $list[] = $bb2;
            }
        }
    }
    */

    protected function recalculateBoundingBox()
    {

        if (($this->getDamage() & 0x04) > 0) {
            return new AxisAlignedBB(
                $this->x,
                $this->y + 0.5,
                $this->z,
                $this->x + 1,
                $this->y + 1,
                $this->z + 1
            );
        } else {
            return new AxisAlignedBB(
                $this->x,
                $this->y,
                $this->z,
                $this->x + 1,
                $this->y + 0.5,
                $this->z + 1
            );
        }
    }

    public function getBurnChance(): int
    {
        return 5;
    }

    public function getBurnAbility(): int
    {
        return 20;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $faces = [
            0 => 0,
            1 => 2,
            2 => 1,
            3 => 3,
        ];
        $this->meta = $faces[$player->getDirection()] & 0x03;
        if (($fy > 0.5 and $face !== 1) or $face === 0) {
            $this->meta |= 0x04; //Upside-down stairs
        }
        $this->getLevel()->setBlock($block, $this, true, true);

        return true;
    }

    public function getHardness()
    {
        return 2;
    }

    public function getResistance()
    {
        return 15;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= Tool::TIER_WOODEN) {
            return [
                [$this->getId(), 0, 1],
            ];
        } else {
            return [];
        }
    }
}