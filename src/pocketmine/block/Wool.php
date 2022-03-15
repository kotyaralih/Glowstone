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


use pocketmine\item\Tool;

class Wool extends Solid
{
    const WHITE = 0;
    const ORANGE = 1;
    const MAGENTA = 2;
    const LIGHT_BLUE = 3;
    const YELLOW = 4;
    const LIME = 5;
    const PINK = 6;
    const GRAY = 7;
    const LIGHT_GRAY = 8;
    const CYAN = 9;
    const PURPLE = 10;
    const BLUE = 11;
    const BROWN = 12;
    const GREEN = 13;
    const RED = 14;
    const BLACK = 15;

    protected $id = self::WOOL;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 0.8;
    }

    public function getToolType()
    {
        return Tool::TYPE_SHEARS;
    }

    public function getName(): string
    {
        static $names = [
            0 => "White Wool",
            1 => "Orange Wool",
            2 => "Magenta Wool",
            3 => "Light Blue Wool",
            4 => "Yellow Wool",
            5 => "Lime Wool",
            6 => "Pink Wool",
            7 => "Gray Wool",
            8 => "Light Gray Wool",
            9 => "Cyan Wool",
            10 => "Purple Wool",
            11 => "Blue Wool",
            12 => "Brown Wool",
            13 => "Green Wool",
            14 => "Red Wool",
            15 => "Black Wool",
        ];
        return $names[$this->meta & 0x0f];
    }

    public function getBurnChance(): int
    {
        return 30;
    }

    public function getBurnAbility(): int
    {
        return 60;
    }

}