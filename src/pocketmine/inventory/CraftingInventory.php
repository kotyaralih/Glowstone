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

/**
 * Manages crafting operations
 * This class includes future methods for shaped crafting
 *
 * TODO: add small matrix inventory
 */
class CraftingInventory extends BaseInventory
{

    /** @var Inventory */
    private $resultInventory;

    /**
     * @param InventoryHolder $holder
     * @param Inventory $resultInventory
     * @param InventoryType $inventoryType
     *
     * @throws \Throwable
     */
    public function __construct(InventoryHolder $holder, Inventory $resultInventory, InventoryType $inventoryType)
    {
        if ($inventoryType->getDefaultTitle() !== "Crafting") {
            throw new \InvalidStateException("Invalid Inventory type, expected CRAFTING or WORKBENCH");
        }
        $this->resultInventory = $resultInventory;
        parent::__construct($holder, $inventoryType);
    }

    /**
     * @return Inventory
     */
    public function getResultInventory()
    {
        return $this->resultInventory;
    }

    public function getSize()
    {
        return $this->getResultInventory()->getSize() + parent::getSize();
    }
}