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
use pocketmine\tile\BrewingStand;

class BrewingInventory extends ContainerInventory
{
    public function __construct(BrewingStand $tile)
    {
        parent::__construct($tile, InventoryType::get(InventoryType::BREWING_STAND));
    }

    /**
     * @return BrewingStand
     */
    public function getHolder()
    {
        return $this->holder;
    }

    public function setIngredient(Item $item)
    {
        $this->setItem(0, $item);
    }

    /**
     * @return Item
     */
    public function getIngredient()
    {
        return $this->getItem(0);
    }

    public function onSlotChange($index, $before)
    {
        parent::onSlotChange($index, $before);

        $this->getHolder()->scheduleUpdate();
        $this->getHolder()->updateSurface();
    }
}