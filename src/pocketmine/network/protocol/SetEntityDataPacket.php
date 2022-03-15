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

class SetEntityDataPacket extends DataPacket
{
    const NETWORK_ID = Info::SET_ENTITY_DATA_PACKET;

    public $eid;
    public $metadata;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->eid);
        $meta = Binary::writeMetadata($this->metadata);
        $this->put($meta);
    }

}
