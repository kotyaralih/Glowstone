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

namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class DoubleTag extends NamedTag
{

    public function getType()
    {
        return NBT::TAG_Double;
    }

    public function read(NBT $nbt)
    {
        $this->value = $nbt->getDouble();
    }

    public function write(NBT $nbt)
    {
        $nbt->putDouble($this->value);
    }
}