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


/**
 * Air block
 */
class Air extends Transparent
{

    protected $id = self::AIR;
    protected $meta = 0;

    public function __construct()
    {

    }

    public function getName(): string
    {
        return "Air";
    }

    public function canPassThrough()
    {
        return true;
    }

    public function isBreakable(Item $item)
    {
        return false;
    }

    public function canBeFlowedInto()
    {
        return true;
    }

    public function canBeReplaced()
    {
        return true;
    }

    public function canBePlaced()
    {
        return false;
    }

    public function isSolid()
    {
        return false;
    }

    public function getBoundingBox()
    {
        return null;
    }

    public function getHardness()
    {
        return 0;
    }

    public function getResistance()
    {
        return 0;
    }

}