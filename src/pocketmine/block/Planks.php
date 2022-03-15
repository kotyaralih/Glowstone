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

class Planks extends Solid
{
    const OAK = 0;
    const SPRUCE = 1;
    const BIRCH = 2;
    const JUNGLE = 3;
    const ACACIA = 4;
    const DARK_OAK = 5;

    protected $id = self::WOODEN_PLANKS;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 2;
    }

    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }

    public function getBurnChance(): int
    {
        return 5;
    }

    public function getBurnAbility(): int
    {
        return 20;
    }

    public function getName(): string
    {
        static $names = [
            self::OAK => "Oak Wood Planks",
            self::SPRUCE => "Spruce Wood Planks",
            self::BIRCH => "Birch Wood Planks",
            self::JUNGLE => "Jungle Wood Planks",
            self::ACACIA => "Acacia Wood Planks",
            self::DARK_OAK => "Jungle Wood Planks",
            "",
            ""
        ];
        return $names[$this->meta & 0x07];
    }

}