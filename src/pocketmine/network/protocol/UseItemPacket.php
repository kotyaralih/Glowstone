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


class UseItemPacket extends DataPacket
{
    const NETWORK_ID = Info::USE_ITEM_PACKET;

    public $x;
    public $y;
    public $z;
    public $face;
    public $item;
    public $fx;
    public $fy;
    public $fz;
    public $posX;
    public $posY;
    public $posZ;
    public $slot;

    public function decode()
    {
        $this->x = $this->getInt();
        $this->y = $this->getInt();
        $this->z = $this->getInt();
        $this->face = $this->getByte();
        $this->fx = $this->getFloat();
        $this->fy = $this->getFloat();
        $this->fz = $this->getFloat();
        $this->posX = $this->getFloat();
        $this->posY = $this->getFloat();
        $this->posZ = $this->getFloat();
        //decode more!
    }

    public function encode()
    {
    }

    public function decodeAdditional($protocol)
    {
        $this->slot = -1;
        if ($protocol >= Info::CURRENT_PROTOCOL) {
            $this->slot = $this->getInt();
        }
        $this->item = $this->getSlot();
    }
}
