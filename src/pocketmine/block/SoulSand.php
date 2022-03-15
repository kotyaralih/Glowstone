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

class SoulSand extends Solid
{

    protected $id = self::SOUL_SAND;

    public function __construct()
    {

    }

    public function getName(): string
    {
        return "Soul Sand";
    }

    public function getHardness()
    {
        return 0.5;
    }

    public function getToolType()
    {
        return Tool::TYPE_SHOVEL;
    }

    protected function recalculateBoundingBox()
    {

        return new AxisAlignedBB(
            $this->x,
            $this->y,
            $this->z,
            $this->x + 1,
            $this->y + 1 - 0.125,
            $this->z + 1
        );
    }

}