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
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\tile\Furnace;
use pocketmine\tile\Tile;

class BurningFurnace extends Solid
{

    protected $id = self::BURNING_FURNACE;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Burning Furnace";
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    public function getHardness()
    {
        return 3.5;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getLightLevel()
    {
        return 13;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $faces = [
            0 => 4,
            1 => 2,
            2 => 5,
            3 => 3,
        ];
        $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];
        $this->getLevel()->setBlock($block, $this, true, true);
        $nbt = new CompoundTag("", [
            new ListTag("Items", []),
            new StringTag("id", Tile::FURNACE),
            new IntTag("x", $this->x),
            new IntTag("y", $this->y),
            new IntTag("z", $this->z)
        ]);
        $nbt->Items->setTagType(NBT::TAG_Compound);

        if ($item->hasCustomName()) {
            $nbt->CustomName = new StringTag("CustomName", $item->getCustomName());
        }

        if ($item->hasCustomBlockData()) {
            foreach ($item->getCustomBlockData() as $key => $v) {
                $nbt->{$key} = $v;
            }
        }

        Tile::createTile("Furnace", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);

        return true;
    }

    public function onBreak(Item $item)
    {
        $this->getLevel()->setBlock($this, new Air(), true, true);

        return true;
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if ($player instanceof Player) {
            $t = $this->getLevel()->getTile($this);
            $furnace = false;
            if ($t instanceof Furnace) {
                $furnace = $t;
            } else {
                $nbt = new CompoundTag("", [
                    new ListTag("Items", []),
                    new StringTag("id", Tile::FURNACE),
                    new IntTag("x", $this->x),
                    new IntTag("y", $this->y),
                    new IntTag("z", $this->z)
                ]);
                $nbt->Items->setTagType(NBT::TAG_Compound);
                $furnace = Tile::createTile("Furnace", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
            }

            if (isset($furnace->namedtag->Lock) and $furnace->namedtag->Lock instanceof StringTag) {
                if ($furnace->namedtag->Lock->getValue() !== $item->getCustomName()) {
                    return true;
                }
            }

            if ($player->isCreative() and $player->getServer()->limitedCreative) {
                return true;
            }

            $player->addWindow($furnace->getInventory());
        }

        return true;
    }

    public function getDrops(Item $item): array
    {
        $drops = [];
        if ($item->isPickaxe() >= 1) {
            $drops[] = [Item::FURNACE, 0, 1];
        }

        return $drops;
    }
}