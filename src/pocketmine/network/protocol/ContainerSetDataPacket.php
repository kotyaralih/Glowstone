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


class ContainerSetDataPacket extends DataPacket
{
    const NETWORK_ID = Info::CONTAINER_SET_DATA_PACKET;

    public $windowid;
    public $property;
    public $value;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putByte($this->windowid);
        $this->putShort($this->property);
        $this->putShort($this->value);
    }

}