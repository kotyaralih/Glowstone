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

#ifndef COMPILE
use pocketmine\utils\Binary;

#endif

class AddPlayerPacket extends DataPacket
{
    const NETWORK_ID = Info::ADD_PLAYER_PACKET;

    public $uuid;
    public $username;
    public $eid;
    public $x;
    public $y;
    public $z;
    public $speedX;
    public $speedY;
    public $speedZ;
    public $pitch;
    public $yaw;
    public $item;
    public $metadata;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putUUID($this->uuid);
        $this->putString($this->username);
        $this->putLong($this->eid);
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putFloat($this->speedX);
        $this->putFloat($this->speedY);
        $this->putFloat($this->speedZ);
        $this->putFloat($this->yaw);
        $this->putFloat($this->yaw); //TODO headrot
        $this->putFloat($this->pitch);
        $this->putSlot($this->item);

        $meta = Binary::writeMetadata($this->metadata);
        $this->put($meta);
    }

}
