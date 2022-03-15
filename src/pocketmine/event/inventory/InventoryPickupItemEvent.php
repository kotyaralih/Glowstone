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

namespace pocketmine\event\inventory;

use pocketmine\entity\Item;
use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;

class InventoryPickupItemEvent extends InventoryEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var Item */
    private $item;

    /**
     * @param Inventory $inventory
     * @param Item $item
     */
    public function __construct(Inventory $inventory, Item $item)
    {
        $this->item = $item;
        parent::__construct($inventory);
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

}