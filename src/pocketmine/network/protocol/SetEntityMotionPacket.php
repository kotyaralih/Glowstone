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


class SetEntityMotionPacket extends DataPacket
{
    const NETWORK_ID = Info::SET_ENTITY_MOTION_PACKET;


    // eid, motX, motY, motZ
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
            $this->putFloat($d[1]); //motX
            $this->putFloat($d[2]); //motY
            $this->putFloat($d[3]); //motZ
        }
    }

}
