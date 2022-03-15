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


class FullChunkDataPacket extends DataPacket
{
    const NETWORK_ID = Info::FULL_CHUNK_DATA_PACKET;

    const ORDER_COLUMNS = 0;
    const ORDER_LAYERED = 1;

    public $chunkX;
    public $chunkZ;
    public $order = self::ORDER_COLUMNS;
    public $data;

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putInt($this->chunkX);
        $this->putInt($this->chunkZ);
        $this->putByte($this->order);
        $this->putInt(strlen($this->data));
        $this->put($this->data);
    }

}
