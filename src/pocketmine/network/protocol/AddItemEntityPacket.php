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


class AddItemEntityPacket extends DataPacket
{
    const NETWORK_ID = Info::ADD_ITEM_ENTITY_PACKET;

    public $eid;
    public $item;
    public $x;
    public $y;
    public $z;
    public $speedX;
    public $speedY;
    public $speedZ;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->eid);
        $this->putSlot($this->item);
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putFloat($this->speedX);
        $this->putFloat($this->speedY);
        $this->putFloat($this->speedZ);
    }

}
