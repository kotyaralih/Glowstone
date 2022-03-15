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


abstract class NamedTag extends Tag
{

    protected $__name;

    /**
     * @param string $name
     * @param bool|float|double|int|byte|short|array|CompoundTag|ListTag|string $value
     */
    public function __construct($name = "", $value = null)
    {
        $this->__name = ($name === null or $name === false) ? "" : $name;
        if ($value !== null) {
            $this->value = $value;
        }
    }

    public function getName()
    {
        return $this->__name;
    }

    public function setName($name)
    {
        $this->__name = $name;
    }
}