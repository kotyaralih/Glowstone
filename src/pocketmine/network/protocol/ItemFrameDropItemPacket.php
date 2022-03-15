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

class ItemFrameDropItemPacket extends DataPacket
{

    const NETWORK_ID = Info::ITEM_FRAME_DROP_ITEM_PACKET;

    public $x;
    public $y;
    public $z;
    public $dropItem;

    public function decode()
    {
        $this->z = $this->getInt();
        $this->y = $this->getInt();
        $this->x = $this->getInt();
        $this->dropItem = $this->getSlot();
    }

    public function encode()
    {
    }
}