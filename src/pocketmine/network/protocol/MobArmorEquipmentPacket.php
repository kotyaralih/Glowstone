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


class MobArmorEquipmentPacket extends DataPacket
{
    const NETWORK_ID = Info::MOB_ARMOR_EQUIPMENT_PACKET;

    public $eid;
    public $slots = [];

    public function decode()
    {
        $this->eid = $this->getLong();
        $this->slots[0] = $this->getSlot();
        $this->slots[1] = $this->getSlot();
        $this->slots[2] = $this->getSlot();
        $this->slots[3] = $this->getSlot();
    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->eid);
        $this->putSlot($this->slots[0]);
        $this->putSlot($this->slots[1]);
        $this->putSlot($this->slots[2]);
        $this->putSlot($this->slots[3]);
    }

}
