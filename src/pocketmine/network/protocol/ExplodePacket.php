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


class ExplodePacket extends DataPacket
{
    const NETWORK_ID = Info::EXPLODE_PACKET;

    public $x;
    public $y;
    public $z;
    public $radius;
    public $records = [];

    public function clean()
    {
        $this->records = [];
        return parent::clean();
    }

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putFloat($this->x);
        $this->putFloat($this->y);
        $this->putFloat($this->z);
        $this->putFloat($this->radius);
        $this->putInt(count($this->records));
        if (count($this->records) > 0) {
            foreach ($this->records as $record) {
                $this->putByte($record->x);
                $this->putByte($record->y);
                $this->putByte($record->z);
            }
        }
    }

}