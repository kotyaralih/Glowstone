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
use pocketmine\Server;
use pocketmine\utils\UUID;

class FurnaceRecipe implements Recipe
{

    private $id = null;

    /** @var Item */
    private $output;

    /** @var Item */
    private $ingredient;

    /**
     * @param Item $result
     * @param Item $ingredient
     */
    public function __construct(Item $result, Item $ingredient)
    {
        $this->output = clone $result;
        $this->ingredient = clone $ingredient;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(UUID $id)
    {
        if ($this->id !== null) {
            throw new \InvalidStateException("Id is already set");
        }

        $this->id = $id;
    }

    /**
     * @param Item $item
     */
    public function setInput(Item $item)
    {
        $this->ingredient = clone $item;
    }

    /**
     * @return Item
     */
    public function getInput()
    {
        return clone $this->ingredient;
    }

    /**
     * @return Item
     */
    public function getResult()
    {
        return clone $this->output;
    }

    public function registerToCraftingManager()
    {
        Server::getInstance()->getCraftingManager()->registerFurnaceRecipe($this);
    }
}