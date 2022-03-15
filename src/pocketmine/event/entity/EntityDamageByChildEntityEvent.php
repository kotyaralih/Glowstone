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

class EntityDamageByChildEntityEvent extends EntityDamageByEntityEvent
{

    /** @var Entity */
    private $childEntity;


    /**
     * @param Entity $damager
     * @param Entity $childEntity
     * @param Entity $entity
     * @param int $cause
     * @param int|int[] $damage
     */
    public function __construct(Entity $damager, Entity $childEntity, Entity $entity, $cause, $damage)
    {
        $this->childEntity = $childEntity;
        parent::__construct($damager, $entity, $cause, $damage);
    }

    /**
     * @return Entity
     */
    public function getChild()
    {
        return $this->childEntity;
    }


}