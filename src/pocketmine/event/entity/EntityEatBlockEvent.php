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
use pocketmine\item\FoodSource;

class EntityEatBlockEvent extends EntityEatEvent
{
    public function __construct(Entity $entity, FoodSource $foodSource)
    {
        if (!($foodSource instanceof Block)) {
            throw new \InvalidArgumentException("Food source must be a block");
        }
        parent::__construct($entity, $foodSource);
    }

    /**
     * @return Block
     */
    public function getResidue()
    {
        return parent::getResidue();
    }

    public function setResidue($residue)
    {
        if (!($residue instanceof Block)) {
            throw new \InvalidArgumentException("Eating a Block can only result in a Block residue");
        }
        parent::setResidue($residue);
    }
}
