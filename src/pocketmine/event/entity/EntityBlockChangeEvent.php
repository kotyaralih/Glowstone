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

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

/**
 * Called when an Entity, excluding players, changes a block directly
 */
class EntityBlockChangeEvent extends EntityEvent implements Cancellable
{
    public static $handlerList = null;

    private $from;
    private $to;

    public function __construct(Entity $entity, Block $from, Block $to)
    {
        $this->entity = $entity;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Block
     */
    public function getBlock()
    {
        return $this->from;
    }

    /**
     * @return Block
     */
    public function getTo()
    {
        return $this->to;
    }

}