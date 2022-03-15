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

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class Wood extends Solid
{
    const OAK = 0;
    const SPRUCE = 1;
    const BIRCH = 2;
    const JUNGLE = 3;

    protected $id = self::WOOD;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 2;
    }

    public function getName(): string
    {
        static $names = [
            self::OAK => "Oak Wood",
            self::SPRUCE => "Spruce Wood",
            self::BIRCH => "Birch Wood",
            self::JUNGLE => "Jungle Wood",
        ];
        return $names[$this->meta & 0x03];
    }

    public function getBurnChance(): int
    {
        return 5;
    }

    public function getBurnAbility(): int
    {
        return 10;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $faces = [
            0 => 0,
            1 => 0,
            2 => 0b1000,
            3 => 0b1000,
            4 => 0b0100,
            5 => 0b0100,
        ];

        $this->meta = ($this->meta & 0x03) | $faces[$face];
        $this->getLevel()->setBlock($block, $this, true, true);

        return true;
    }

    public function getDrops(Item $item): array
    {
        return [
            [$this->id, $this->meta & 0x03, 1],
        ];
    }

    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }
}