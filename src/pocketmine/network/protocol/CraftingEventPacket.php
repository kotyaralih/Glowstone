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


class CraftingEventPacket extends DataPacket
{
    const NETWORK_ID = Info::CRAFTING_EVENT_PACKET;

    public $windowId;
    public $type;
    public $id;
    public $input = [];
    public $output = [];

    public function clean()
    {
        $this->input = [];
        $this->output = [];
        return parent::clean();
    }

    public function decode()
    {
        $this->windowId = $this->getByte();
        $this->type = $this->getInt();
        $this->id = $this->getUUID();

        $size = $this->getInt();
        for ($i = 0; $i < $size and $i < 128; ++$i) {
            $this->input[] = $this->getSlot();
        }

        $size = $this->getInt();
        for ($i = 0; $i < $size and $i < 128; ++$i) {
            $this->output[] = $this->getSlot();
        }
    }

    public function encode()
    {

    }

}
