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

use pocketmine\entity\Arrow;
use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;

class InventoryPickupArrowEvent extends InventoryEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var Arrow */
    private $arrow;

    /**
     * @param Inventory $inventory
     * @param Arrow $arrow
     */
    public function __construct(Inventory $inventory, Arrow $arrow)
    {
        $this->arrow = $arrow;
        parent::__construct($inventory);
    }

    /**
     * @return Arrow
     */
    public function getArrow()
    {
        return $this->arrow;
    }

}