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

class EntityCombustByBlockEvent extends EntityCombustEvent
{

    protected $combuster;

    /**
     * @param Block $combuster
     * @param Entity $combustee
     * @param int $duration
     */
    public function __construct(Block $combuster, Entity $combustee, $duration)
    {
        parent::__construct($combustee, $duration);
        $this->combuster = $combuster;
    }

    /**
     * @return Block
     */
    public function getCombuster()
    {
        return $this->combuster;
    }

}