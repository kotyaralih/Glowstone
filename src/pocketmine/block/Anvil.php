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

use pocketmine\inventory\AnvilInventory;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\Player;

class Anvil extends Fallable
{

    protected $id = self::ANVIL;

    public function isSolid()
    {
        return false;
    }

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function getHardness()
    {
        return 5;
    }

    public function getResistance()
    {
        return 6000;
    }

    public function getName(): string
    {
        return "Anvil";
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if (!$this->getLevel()->getServer()->anviletEnabled) return true;
        if ($player instanceof Player) {
            if ($player->isCreative() and $player->getServer()->limitedCreative) {
                return true;
            }

            $player->addWindow(new AnvilInventory($this));
        }

        return true;
    }

    public function onBreak(Item $item)
    {
        parent::onBreak($item);
        $sound = new AnvilBreakSound($this);
        $this->getLevel()->addSound($sound);
    }

    public function getDrops(Item $item): array
    {
        if ($item->isPickaxe() >= 1) {
            return [
                [$this->id, 0, 1], //TODO break level
            ];
        } else {
            return [];
        }
    }
}