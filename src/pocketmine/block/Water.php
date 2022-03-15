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

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\Player;

class Water extends Liquid
{

    protected $id = self::WATER;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Water";
    }

    public function onEntityCollide(Entity $entity)
    {
        $entity->resetFallDistance();
        if ($entity->fireTicks > 0) {
            $entity->extinguish();
        }

        $entity->resetFallDistance();
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $ret = $this->getLevel()->setBlock($this, $this, true, false);
        $this->getLevel()->scheduleUpdate($this, $this->tickRate());

        return $ret;
    }
}
