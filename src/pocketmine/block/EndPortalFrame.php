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
use pocketmine\math\AxisAlignedBB;

class EndPortalFrame extends Solid
{

    protected $id = self::END_PORTAL_FRAME;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getLightLevel()
    {
        return 1;
    }

    public function getName(): string
    {
        return "End Portal Frame";
    }

    public function getHardness()
    {
        return -1;
    }

    public function getResistance()
    {
        return 18000000;
    }

    public function isBreakable(Item $item)
    {
        return false;
    }

    protected function recalculateBoundingBox()
    {

        return new AxisAlignedBB(
            $this->x,
            $this->y,
            $this->z,
            $this->x + 1,
            $this->y + (($this->getDamage() & 0x04) > 0 ? 1 : 0.8125),
            $this->z + 1
        );
    }
}