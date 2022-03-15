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

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class GenericParticle extends Particle
{

    protected $id;
    protected $data;

    public function __construct(Vector3 $pos, $id, $data = 0)
    {
        parent::__construct($pos->x, $pos->y, $pos->z);
        $this->id = $id & 0xFFF;
        $this->data = $data;
    }

    public function encode()
    {
        $pk = new LevelEventPacket;
        $pk->evid = LevelEventPacket::EVENT_ADD_PARTICLE_MASK | $this->id;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->data = $this->data;

        return $pk;
    }
}
