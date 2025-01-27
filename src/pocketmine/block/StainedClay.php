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

class StainedClay extends Solid
{

    protected $id = self::STAINED_CLAY;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 1.25;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getName(): string
    {
        static $names = [
            0 => "White Stained Clay",
            1 => "Orange Stained Clay",
            2 => "Magenta Stained Clay",
            3 => "Light Blue Stained Clay",
            4 => "Yellow Stained Clay",
            5 => "Lime Stained Clay",
            6 => "Pink Stained Clay",
            7 => "Gray Stained Clay",
            8 => "Light Gray Stained Clay",
            9 => "Cyan Stained Clay",
            10 => "Purple Stained Clay",
            11 => "Blue Stained Clay",
            12 => "Brown Stained Clay",
            13 => "Green Stained Clay",
            14 => "Red Stained Clay",
            15 => "Black Stained Clay",
        ];
        return $names[$this->meta & 0x0f];
    }

}