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


class MoveEntityPacket extends DataPacket
{
    const NETWORK_ID = Info::MOVE_ENTITY_PACKET;


    // eid, x, y, z, yaw, pitch
    /** @var array[] */
    public $entities = [];

    public function clean()
    {
        $this->entities = [];
        return parent::clean();
    }

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putInt(count($this->entities));
        foreach ($this->entities as $d) {
            $this->putLong($d[0]); //eid
            $this->putFloat($d[1]); //x
            $this->putFloat($d[2]); //y
            $this->putFloat($d[3]); //z
            $this->putFloat($d[4]); //yaw
            $this->putFloat($d[5]); //headYaw
            $this->putFloat($d[6]); //pitch
        }
    }

}
