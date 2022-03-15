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

use pocketmine\item\enchantment\enchantment;
use pocketmine\item\Item;
use pocketmine\item\Tool;

class Stone extends Solid
{
    const NORMAL = 0;
    const GRANITE = 1;
    const POLISHED_GRANITE = 2;
    const DIORITE = 3;
    const POLISHED_DIORITE = 4;
    const ANDESITE = 5;
    const POLISHED_ANDESITE = 6;

    protected $id = self::STONE;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 1.5;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getName(): string
    {
        static $names = [
            self::NORMAL => "Stone",
            self::GRANITE => "Granite",
            self::POLISHED_GRANITE => "Polished Granite",
            self::DIORITE => "Diorite",
            self::POLISHED_DIORITE => "Polished Diorite",
            self::ANDESITE => "Andesite",
            self::POLISHED_ANDESITE => "Polished Andesite",
            7 => "Unknown Stone",
        ];
        return $names[(int)$this->meta & 0x07];
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= Tool::TIER_WOODEN) {
            if ($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0 and $this->getDamage() === 0) {
                return [
                    [Item::STONE, 0, 1],
                ];
            }
            return [
                [$this->getDamage() === 0 ? Item::COBBLESTONE : Item::STONE, $this->getDamage(), 1],
            ];
        } else {
            return [];
        }
    }

}