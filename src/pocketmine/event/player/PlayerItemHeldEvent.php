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

use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerItemHeldEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    private $item;
    private $slot;
    private $inventorySlot;

    public function __construct(Player $player, Item $item, $inventorySlot, $slot)
    {
        $this->player = $player;
        $this->item = $item;
        $this->inventorySlot = (int)$inventorySlot;
        $this->slot = (int)$slot;
    }

    public function getSlot()
    {
        return $this->slot;
    }

    public function getInventorySlot()
    {
        return $this->inventorySlot;
    }

    public function getItem()
    {
        return $this->item;
    }

}