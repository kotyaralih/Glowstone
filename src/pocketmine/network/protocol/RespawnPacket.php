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


class RespawnPacket extends DataPacket
{
    const NETWORK_ID = Info::RESPAWN_PACKET;

    public $x;
    public $y;
    public $z;

    public function decode()
    {
        $this->x = $this->getFloat();
        $this->y = $this->getFloat();
        $this->z = $this->getFloat();
    }

    public function encode()
    {
        $this->reset();
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
    }

}
