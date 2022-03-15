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

use pocketmine\item\Item;

class ContainerSetSlotPacket extends DataPacket
{
    const NETWORK_ID = Info::CONTAINER_SET_SLOT_PACKET;

    public $windowid;
    public $slot;
    /** @var Item */
    public $item;
    public $hotbarSlot;

    public function decode()
    {
        $this->windowid = $this->getByte();
        $this->slot = $this->getShort();
        $this->hotbarSlot = $this->getShort();
        $this->item = $this->getSlot();
    }

    public function encode()
    {
        $this->reset();
        $this->putByte($this->windowid);
        $this->putShort($this->slot);
        $this->putShort($this->hotbarSlot);
        $this->putSlot($this->item);
    }

}
