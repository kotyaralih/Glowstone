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


class MovePlayerPacket extends DataPacket
{
    const NETWORK_ID = Info::MOVE_PLAYER_PACKET;

    const MODE_NORMAL = 0;
    const MODE_RESET = 1;
    const MODE_ROTATION = 2;

    public $eid;
    public $x;
    public $y;
    public $z;
    public $yaw;
    public $bodyYaw;
    public $pitch;
    public $mode = self::MODE_NORMAL;
    public $onGround;

    public function clean()
    {
        $this->teleport = false;
        return parent::clean();
    }

    public function decode()
    {
        $this->eid = $this->getLong();
        $this->x = $this->getFloat();
        $this->y = $this->getFloat();
        $this->z = $this->getFloat();
        $this->yaw = $this->getFloat();
        $this->bodyYaw = $this->getFloat();
        $this->pitch = $this->getFloat();
        $this->mode = $this->getByte();
        $this->onGround = $this->getByte() > 0;
    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->eid);
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putFloat($this->yaw);
        $this->putFloat($this->bodyYaw); //TODO
        $this->putFloat($this->pitch);
        $this->putByte($this->mode);
        $this->putByte($this->onGround > 0);
    }

}
