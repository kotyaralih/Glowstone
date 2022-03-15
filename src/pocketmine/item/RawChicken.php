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

use pocketmine\entity\Effect;

class RawChicken extends Food
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::RAW_CHICKEN, $meta, $count, "Raw Chicken");
    }

    public function getFoodRestore(): int
    {
        return 2;
    }

    public function getSaturationRestore(): float
    {
        return 1.2;
    }

    public function getAdditionalEffects(): array
    {
        if (mt_rand(0, 9) < 3) {
            return [Effect::getEffect(Effect::HUNGER)->setDuration(600)];
        } else {
            return [];
        }
    }
}

