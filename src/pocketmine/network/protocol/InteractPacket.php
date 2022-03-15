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


class InteractPacket extends DataPacket
{
    const NETWORK_ID = Info::INTERACT_PACKET;

    const ACTION_RIGHT_CLICK = 1;
    const ACTION_LEFT_CLICK = 2;
    const ACTION_LEAVE_VEHICLE = 3;

    public $action;
    public $eid;
    public $target;

    public function decode()
    {
        $this->action = $this->getByte();
        $this->target = $this->getLong();
    }

    public function encode()
    {
        $this->reset();
        $this->putByte($this->action);
        $this->putLong($this->target);
    }

}
