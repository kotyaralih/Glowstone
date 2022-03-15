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

namespace pocketmine\tile;

use pocketmine\inventory\EnchantInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class EnchantTable extends Spawnable implements InventoryHolder, Nameable
{
    /** @var EnchantInventory */
    protected $inventory;

    public function __construct(FullChunk $chunk, CompoundTag $nbt)
    {
        parent::__construct($chunk, $nbt);
        $this->inventory = new EnchantInventory($this);
    }

    public function getName(): string
    {
        return $this->hasName() ? $this->namedtag->CustomName->getValue() : "Enchanting Table";
    }

    public function hasName()
    {
        return isset($this->namedtag->CustomName);
    }

    public function setName($str)
    {
        if ($str === "") {
            unset($this->namedtag->CustomName);
            return;
        }

        $this->namedtag->CustomName = new StringTag("CustomName", $str);
    }

    /**
     * @return EnchantInventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    public function getSpawnCompound()
    {
        $nbt = new CompoundTag("", [
            new StringTag("id", Tile::ENCHANT_TABLE),
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z)
        ]);

        if ($this->hasName()) {
            $nbt->CustomName = $this->namedtag->CustomName;
        }

        return $nbt;
    }
}
