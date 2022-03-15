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

namespace pocketmine\event\player;

use pocketmine\entity\FishingHook;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Called when a player uses the fishing rod
 */
class PlayerFishEvent extends PlayerEvent implements Cancellable
{

    public static $handlerList = null;

    /** @var Item */
    private $item;

    /** @var FishingHook */
    private $hook;

    /**
     * @param Player $player
     * @param Item $item
     * @param        $fishingHook
     */
    public function __construct(Player $player, Item $item, $fishingHook = null)
    {
        $this->player = $player;
        $this->item = $item;
        $this->hook = $fishingHook;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return clone $this->item;
    }

    public function getHook()
    {
        return $this->hook;
    }
}
