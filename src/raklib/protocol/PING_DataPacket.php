<?php

/*
 *  ___	  _   _	_ _
 * | _ \__ _| |_| |  (_) |__
 * |   / _` | / / |__| | '_ \
 * |_|_\__,_|_\_\____|_|_.__/
 *
 * This project is not affiliated with Jenkins Software LLC nor RakNet.
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

namespace raklib\protocol;

#include <rules/RakLibPacket.h>

class PING_DataPacket extends Packet
{
    public static $ID = 0x00;

    public $pingID;

    public function encode()
    {
        parent::encode();
        $this->putLong($this->pingID);
    }

    public function decode()
    {
        parent::decode();
        $this->pingID = $this->getLong();
    }
}