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

class Fish extends Food
{
    const FISH_FISH = 0;
    const FISH_SALMON = 1;
    const FISH_CLOWNFISH = 2;
    const FISH_PUFFERFISH = 3;

    public function __construct($meta = 0, $count = 1)
    {
        $name = "Raw Fish";
        if ($this->meta === self::FISH_SALMON) {
            $name = "Raw Salmon";
        } elseif ($this->meta === self::FISH_CLOWNFISH) {
            $name = "Clownfish";
        } elseif ($this->meta === self::FISH_PUFFERFISH) {
            $name = "Pufferfish";
        }
        parent::__construct(self::RAW_FISH, $meta, $count, $name);
    }

    public function getFoodRestore(): int
    {
        if ($this->meta === self::FISH_FISH) {
            return 2;
        } elseif ($this->meta === self::FISH_SALMON) {
            return 2;
        } elseif ($this->meta === self::FISH_CLOWNFISH) {
            return 1;
        } elseif ($this->meta === self::FISH_PUFFERFISH) {
            return 1.2;
        }
        return 0;
    }

    public function getSaturationRestore(): float
    {
        if ($this->meta === self::FISH_FISH) {
            return 0.4;
        } elseif ($this->meta === self::FISH_SALMON) {
            return 0.4;
        } elseif ($this->meta === self::FISH_CLOWNFISH) {
            return 0.2;
        } elseif ($this->meta === self::FISH_PUFFERFISH) {
            return 0.2;
        }
        return 0;
    }

    public function getAdditionalEffects(): array
    {
        return $this->meta === self::FISH_PUFFERFISH ? [
            Effect::getEffect(Effect::HUNGER)->setDuration(300)->setAmplifier(2),
            Effect::getEffect(Effect::NAUSEA)->setDuration(300)->setAmplifier(1),
            Effect::getEffect(Effect::POISON)->setDuration(1200)->setAmplifier(3),
        ] : [];
    }
}
