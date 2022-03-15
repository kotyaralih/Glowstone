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

use pocketmine\event\block\BlockEvent;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\tile\Furnace;

class FurnaceBurnEvent extends BlockEvent implements Cancellable
{
    public static $handlerList = null;

    private $furnace;
    private $fuel;
    private $burnTime;
    private $burning = true;

    public function __construct(Furnace $furnace, Item $fuel, $burnTime)
    {
        parent::__construct($furnace->getBlock());
        $this->fuel = $fuel;
        $this->burnTime = (int)$burnTime;
        $this->furnace = $furnace;
    }

    /**
     * @return Furnace
     */
    public function getFurnace()
    {
        return $this->furnace;
    }

    /**
     * @return Item
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * @return int
     */
    public function getBurnTime()
    {
        return $this->burnTime;
    }

    /**
     * @param int $burnTime
     */
    public function setBurnTime($burnTime)
    {
        $this->burnTime = (int)$burnTime;
    }

    /**
     * @return bool
     */
    public function isBurning()
    {
        return $this->burning;
    }

    /**
     * @param bool $burning
     */
    public function setBurning($burning)
    {
        $this->burning = (bool)$burning;
    }
}