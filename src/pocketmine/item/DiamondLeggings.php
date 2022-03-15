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


class DiamondLeggings extends Armor
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::DIAMOND_LEGGINGS, $meta, $count, "Diamond Leggings");
    }

    public function getArmorTier()
    {
        return Armor::TIER_DIAMOND;
    }

    public function getArmorType()
    {
        return Armor::TYPE_LEGGINGS;
    }

    public function getMaxDurability()
    {
        return 496;
    }

    public function getArmorValue()
    {
        return 6;
    }

    public function isLeggings()
    {
        return true;
    }
}