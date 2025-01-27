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
use pocketmine\level\Level;

class RedstoneOre extends Solid
{

    protected $id = self::REDSTONE_ORE;

    public function __construct()
    {

    }

    public function getName(): string
    {
        return "Redstone Ore";
    }

    public function getHardness()
    {
        return 3;
    }

    public function onUpdate($type)
    {
        if ($type === Level::BLOCK_UPDATE_NORMAL or $type === Level::BLOCK_UPDATE_TOUCH) {
            $this->getLevel()->setBlock($this, Block::get(Item::GLOWING_REDSTONE_ORE, $this->meta));

            return Level::BLOCK_UPDATE_WEAK;
        }

        return false;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= Tool::TIER_IRON) {
            if ($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0) {
                return [
                    [Item::REDSTONE_ORE, 0, 1],
                ];
            } else {
                $fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
                $fortunel = $fortunel > 3 ? 3 : $fortunel;
                return [
                    [Item::REDSTONE_DUST, 0, mt_rand(4, 5 + $fortunel)],
                ];
            }
        } else {
            return [];
        }
    }
}
