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

class GoldenApple extends Food
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::GOLDEN_APPLE, $meta, $count, ($meta === 1 ? "Enchanted " : "") . "Golden Apple");
    }

    public function getFoodRestore(): int
    {
        return 4;
    }

    public function getSaturationRestore(): float
    {
        return 9.6;
    }

    public function getAdditionalEffects(): array
    {
        return $this->meta === 1 ? [
            Effect::getEffect(Effect::REGENERATION)->setDuration(600)->setAmplifier(4),
            Effect::getEffect(Effect::ABSORPTION)->setDuration(2400),
            Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(6000),
            Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(6000),
        ] : [
            Effect::getEffect(Effect::REGENERATION)->setDuration(100)->setAmplifier(1),
            Effect::getEffect(Effect::ABSORPTION)->setDuration(2400)
        ];
    }
}

