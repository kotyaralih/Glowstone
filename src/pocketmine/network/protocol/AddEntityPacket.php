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

class AddEntityPacket extends DataPacket
{
    const NETWORK_ID = Info::ADD_ENTITY_PACKET;

    public $eid;
    public $type;
    public $x;
    public $y;
    public $z;
    public $speedX;
    public $speedY;
    public $speedZ;
    public $yaw;
    public $pitch;
    public $metadata;
    public $links = [];

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->eid);
        $this->putInt($this->type);
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putFloat($this->speedX);
        $this->putFloat($this->speedY);
        $this->putFloat($this->speedZ);
        $this->putFloat($this->yaw);
        $this->putFloat($this->pitch);
        $meta = Binary::writeMetadata($this->metadata);
        $this->put($meta);
        $this->putShort(count($this->links));
        foreach ($this->links as $link) {
            $this->putLong($link[0]);
            $this->putLong($link[1]);
            $this->putByte($link[2]);
        }
    }

}
