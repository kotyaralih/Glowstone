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

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\inventory\Recipe;
use pocketmine\item\Item;
use pocketmine\Player;

class CraftItemEvent extends Event implements Cancellable
{
    public static $handlerList = null;
    /** @var Item[] */
    private $input = [];
    /** @var Recipe */
    private $recipe;
    /** @var \pocketmine\Player */
    private $player;

    /**
     * @param \pocketmine\Player $player
     * @param Item[] $input
     * @param Recipe $recipe
     */
    public function __construct(Player $player, array $input, Recipe $recipe)
    {
        $this->player = $player;
        $this->input = $input;
        $this->recipe = $recipe;
    }

    /**
     * @return Item[]
     */
    public function getInput()
    {
        $items = [];
        foreach ($items as $i => $item) {
            $items[$i] = clone $item;
        }
        return $items;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @return \pocketmine\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}