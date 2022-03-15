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

namespace pocketmine\entity;


abstract class Animal extends Creature implements Ageable
{

    public function initEntity()
    {
        parent::initEntity();
        if ($this->getDataProperty(self::DATA_AGEABLE_FLAGS) === null) {
            $this->setDataProperty(self::DATA_AGEABLE_FLAGS, self::DATA_TYPE_BYTE, 0);
        }
    }

    public function isBaby()
    {
        return $this->getDataFlag(self::DATA_AGEABLE_FLAGS, self::DATA_FLAG_BABY);
    }
}