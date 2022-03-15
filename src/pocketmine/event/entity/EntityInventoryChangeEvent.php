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

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;

class EntityInventoryChangeEvent extends EntityEvent implements Cancellable
{
    public static $handlerList = null;

    private $oldItem;
    private $newItem;
    private $slot;

    public function __construct(Entity $entity, Item $oldItem, Item $newItem, $slot)
    {
        $this->entity = $entity;
        $this->oldItem = $oldItem;
        $this->newItem = $newItem;
        $this->slot = (int)$slot;
    }

    public function getSlot()
    {
        return $this->slot;
    }

    public function getNewItem()
    {
        return $this->newItem;
    }

    public function setNewItem(Item $item)
    {
        $this->newItem = $item;
    }

    public function getOldItem()
    {
        return $this->oldItem;
    }


}