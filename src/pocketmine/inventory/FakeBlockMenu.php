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


use pocketmine\level\Position;


class FakeBlockMenu extends Position implements InventoryHolder
{

    private $inventory;

    public function __construct(Inventory $inventory, Position $pos)
    {
        $this->inventory = $inventory;
        parent::__construct($pos->x, $pos->y, $pos->z, $pos->level);
    }

    public function getInventory()
    {
        return $this->inventory;
    }
}