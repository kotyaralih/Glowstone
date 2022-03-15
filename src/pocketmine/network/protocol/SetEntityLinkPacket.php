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


class SetEntityLinkPacket extends DataPacket
{
    const NETWORK_ID = Info::SET_ENTITY_LINK_PACKET;

    const TYPE_REMOVE = 0;
    const TYPE_RIDE = 1;
    const TYPE_PASSENGER = 2;


    public $from;
    public $to;
    public $type;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->from);
        $this->putLong($this->to);
        $this->putByte($this->type);
    }

}
