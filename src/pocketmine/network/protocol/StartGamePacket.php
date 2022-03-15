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

namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class StartGamePacket extends DataPacket
{
    const NETWORK_ID = Info::START_GAME_PACKET;

    public $seed;
    public $dimension;
    public $generator;
    public $gamemode;
    public $eid;
    public $spawnX;
    public $spawnY;
    public $spawnZ;
    public $x;
    public $y;
    public $z;
    public $unknown;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putInt($this->seed);
        $this->putByte($this->dimension);
        $this->putInt($this->generator);
        $this->putInt($this->gamemode);
        $this->putLong($this->eid);
        $this->putInt($this->spawnX);
        $this->putInt($this->spawnY);
        $this->putInt($this->spawnZ);
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putByte(1);
        $this->putByte(1);
        $this->putByte(0);
        $this->putString($this->unknown);
    }

}
