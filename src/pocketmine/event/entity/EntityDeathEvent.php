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

use pocketmine\entity\Living;
use pocketmine\item\Item;

class EntityDeathEvent extends EntityEvent
{
    public static $handlerList = null;

    /** @var Item[] */
    private $drops = [];


    /**
     * @param Living $entity
     * @param Item[] $drops
     */
    public function __construct(Living $entity, array $drops = [])
    {
        $this->entity = $entity;
        $this->drops = $drops;
    }

    /**
     * @return Living
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return \pocketmine\item\Item[]
     */
    public function getDrops()
    {
        return $this->drops;
    }

    /**
     * @param Item[] $drops
     */
    public function setDrops(array $drops)
    {
        $this->drops = $drops;
    }

}