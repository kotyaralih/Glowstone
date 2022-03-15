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

/**
 * All the NBT Tags
 */

namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

abstract class Tag extends \stdClass
{

    protected $value;

    public function &getValue()
    {
        return $this->value;
    }

    public abstract function getType();

    public function setValue($value)
    {
        $this->value = $value;
    }

    abstract public function write(NBT $nbt);

    abstract public function read(NBT $nbt);

    public function __toString()
    {
        return (string)$this->value;
    }
}
