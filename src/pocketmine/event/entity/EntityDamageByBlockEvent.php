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

class EntityDamageByBlockEvent extends EntityDamageEvent
{

    /** @var Block */
    private $damager;


    /**
     * @param Block $damager
     * @param Entity $entity
     * @param int $cause
     * @param int|int[] $damage
     */
    public function __construct(Block $damager, Entity $entity, $cause, $damage)
    {
        $this->damager = $damager;
        parent::__construct($entity, $cause, $damage);
    }

    /**
     * @return Block
     */
    public function getDamager()
    {
        return $this->damager;
    }


}