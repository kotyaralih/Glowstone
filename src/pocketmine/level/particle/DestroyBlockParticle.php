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

namespace pocketmine\level\particle;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class DestroyBlockParticle extends Particle
{

    protected $data;

    public function __construct(Vector3 $pos, Block $b)
    {
        parent::__construct($pos->x, $pos->y, $pos->z);
        $this->data = $b->getId() + ($b->getDamage() << 12);
    }

    public function encode()
    {
        $pk = new LevelEventPacket;
        $pk->evid = LevelEventPacket::EVENT_PARTICLE_DESTROY;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->data = $this->data;

        return $pk;
    }
}
