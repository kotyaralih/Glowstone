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

class IntArrayTag extends NamedTag
{

    public function getType()
    {
        return NBT::TAG_IntArray;
    }

    public function read(NBT $nbt)
    {
        [];
        $size = $nbt->getInt();
        $this->value = array_values(unpack($nbt->endianness === NBT::LITTLE_ENDIAN ? "V*" : "N*", $nbt->get($size * 4)));
    }

    public function write(NBT $nbt)
    {
        $nbt->putInt(count($this->value));
        $nbt->put(pack($nbt->endianness === NBT::LITTLE_ENDIAN ? "V*" : "N*", ...$this->value));
    }

    public function __toString()
    {
        $str = get_class($this) . "{\n";
        $str .= implode(", ", $this->value);
        return $str . "}";
    }
}