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

namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class GenericSound extends Sound
{

    public function __construct(Vector3 $pos, $id, $pitch = 0)
    {
        parent::__construct($pos->x, $pos->y, $pos->z);
        $this->id = (int)$id;
        $this->pitch = (float)$pitch * 1000;
    }

    protected $pitch = 0;
    protected $id;

    public function getPitch()
    {
        return $this->pitch / 1000;
    }

    public function setPitch($pitch)
    {
        $this->pitch = (float)$pitch * 1000;
    }


    public function encode()
    {
        $pk = new LevelEventPacket;
        $pk->evid = $this->id;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->data = (int)$this->pitch;

        return $pk;
    }

}
