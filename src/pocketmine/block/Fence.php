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

use pocketmine\item\Tool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class Fence extends Transparent
{

    const FENCE_OAK = 0;
    const FENCE_SPRUCE = 1;
    const FENCE_BIRCH = 2;
    const FENCE_JUNGLE = 3;
    const FENCE_ACACIA = 4;
    const FENCE_DARKOAK = 5;

    protected $id = self::FENCE;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 2;
    }

    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }

    public function getBurnChance(): int
    {
        return 5;
    }

    public function getBurnAbility(): int
    {
        return 20;
    }

    public function getName(): string
    {
        static $names = [
            0 => "Oak Fence",
            1 => "Spruce Fence",
            2 => "Birch Fence",
            3 => "Jungle Fence",
            4 => "Acacia Fence",
            5 => "Dark Oak Fence",
            "",
            ""
        ];
        return $names[$this->meta & 0x07];
    }

    protected function recalculateBoundingBox()
    {

        $north = $this->canConnect($this->getSide(Vector3::SIDE_NORTH));
        $south = $this->canConnect($this->getSide(Vector3::SIDE_SOUTH));
        $west = $this->canConnect($this->getSide(Vector3::SIDE_WEST));
        $east = $this->canConnect($this->getSide(Vector3::SIDE_EAST));

        $n = $north ? 0 : 0.375;
        $s = $south ? 1 : 0.625;
        $w = $west ? 0 : 0.375;
        $e = $east ? 1 : 0.625;

        return new AxisAlignedBB(
            $this->x + $w,
            $this->y,
            $this->z + $n,
            $this->x + $e,
            $this->y + 1.5,
            $this->z + $s
        );
    }

    public function canConnect(Block $block)
    {
        return ($block instanceof Fence or $block instanceof FenceGate) ? true : $block->isSolid() and !$block->isTransparent();
    }

}
