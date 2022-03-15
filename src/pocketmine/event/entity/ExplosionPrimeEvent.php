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

/**
 * Called when a entity decides to explode
 */
class ExplosionPrimeEvent extends EntityEvent implements Cancellable
{
    public static $handlerList = null;

    protected $force;
    private $blockBreaking;

    /**
     * @param Entity $entity
     * @param float $force
     */
    public function __construct(Entity $entity, $force)
    {
        $this->entity = $entity;
        $this->force = $force;
        $this->blockBreaking = true;
    }

    /**
     * @return float
     */
    public function getForce()
    {
        return $this->force;
    }

    public function setForce($force)
    {
        $this->force = (float)$force;
    }

    /**
     * @return bool
     */
    public function isBlockBreaking()
    {
        return $this->blockBreaking;
    }

    /**
     * @param bool $affectsBlocks
     */
    public function setBlockBreaking($affectsBlocks)
    {
        $this->blockBreaking = (bool)$affectsBlocks;
    }

}