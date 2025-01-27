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

namespace pocketmine\inventory;

use pocketmine\item\Item;

class BaseTransaction implements Transaction
{
    /** @var Inventory */
    protected $inventory;
    /** @var int */
    protected $slot;
    /** @var Item */
    protected $sourceItem;
    /** @var Item */
    protected $targetItem;
    /** @var float */
    protected $creationTime;

    /**
     * @param Inventory $inventory
     * @param int $slot
     * @param Item $sourceItem
     * @param Item $targetItem
     */
    public function __construct(Inventory $inventory, $slot, Item $sourceItem, Item $targetItem)
    {
        $this->inventory = $inventory;
        $this->slot = (int)$slot;
        $this->sourceItem = clone $sourceItem;
        $this->targetItem = clone $targetItem;
        $this->creationTime = microtime(true);
    }

    public function getCreationTime()
    {
        return $this->creationTime;
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function getSlot()
    {
        return $this->slot;
    }

    public function getSourceItem()
    {
        return clone $this->sourceItem;
    }

    public function getTargetItem()
    {
        return clone $this->targetItem;
    }
}