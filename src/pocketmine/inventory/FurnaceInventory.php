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
use pocketmine\tile\Furnace;

class FurnaceInventory extends ContainerInventory
{
    public function __construct(Furnace $tile)
    {
        parent::__construct($tile, InventoryType::get(InventoryType::FURNACE));
    }

    /**
     * @return Furnace
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @return Item
     */
    public function getResult()
    {
        return $this->getItem(2);
    }

    /**
     * @return Item
     */
    public function getFuel()
    {
        return $this->getItem(1);
    }

    /**
     * @return Item
     */
    public function getSmelting()
    {
        return $this->getItem(0);
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function setResult(Item $item)
    {
        return $this->setItem(2, $item);
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function setFuel(Item $item)
    {
        return $this->setItem(1, $item);
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function setSmelting(Item $item)
    {
        return $this->setItem(0, $item);
    }

    public function onSlotChange($index, $before)
    {
        parent::onSlotChange($index, $before);

        $this->getHolder()->scheduleUpdate();
    }
}
