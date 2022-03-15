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
use pocketmine\item\Food;
use pocketmine\item\Item;

class EntityEatItemEvent extends EntityEatEvent
{
    public function __construct(Entity $entity, Food $foodSource)
    {
        parent::__construct($entity, $foodSource);
    }

    /**
     * @return Item
     */
    public function getResidue()
    {
        return parent::getResidue();
    }

    public function setResidue($residue)
    {
        if (!($residue instanceof Item)) {
            throw new \InvalidArgumentException("Eating an Item can only result in an Item residue");
        }
        parent::setResidue($residue);
    }
}
