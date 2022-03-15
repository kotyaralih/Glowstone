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
use pocketmine\entity\Living;
use pocketmine\entity\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;

class EntityShootBowEvent extends EntityEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var Item */
    private $bow;
    /** @var Projectile */
    private $projectile;
    /** @var float */
    private $force;

    /**
     * @param Living $shooter
     * @param Item $bow
     * @param Projectile $projectile
     * @param float $force
     */
    public function __construct(Living $shooter, Item $bow, Projectile $projectile, $force)
    {
        $this->entity = $shooter;
        $this->bow = $bow;
        $this->projectile = $projectile;
        $this->force = $force;
    }

    /**
     * @return Living
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return Item
     */
    public function getBow()
    {
        return $this->bow;
    }

    /**
     * @return Entity|Projectile
     */
    public function getProjectile()
    {
        return $this->projectile;
    }

    /**
     * @param Entity $projectile
     */
    public function setProjectile(Entity $projectile)
    {
        if ($projectile !== $this->projectile) {
            if (count($this->projectile->getViewers()) === 0) {
                $this->projectile->kill();
                $this->projectile->close();
            }
            $this->projectile = $projectile;
        }
    }

    /**
     * @return float
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * @param float $force
     */
    public function setForce($force)
    {
        $this->force = $force;
    }


}