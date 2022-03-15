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

/**
 * Inventory related events
 */

namespace pocketmine\event\inventory;

use pocketmine\event\Event;
use pocketmine\inventory\Inventory;

abstract class InventoryEvent extends Event
{

    /** @var Inventory */
    protected $inventory;

    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @return Inventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @return \pocketmine\entity\Human[]
     */
    public function getViewers()
    {
        return $this->inventory->getViewers();
    }
}