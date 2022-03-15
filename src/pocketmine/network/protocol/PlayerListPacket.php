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


class PlayerListPacket extends DataPacket
{
    const NETWORK_ID = Info::PLAYER_LIST_PACKET;

    const TYPE_ADD = 0;
    const TYPE_REMOVE = 1;

    //REMOVE: UUID, ADD: UUID, entity id, name, isSlim, skin
    /** @var array[] */
    public $entries = [];
    public $type;

    public function clean()
    {
        $this->entries = [];
        return parent::clean();
    }

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putByte($this->type);
        $this->putInt(count($this->entries));
        foreach ($this->entries as $d) {
            if ($this->type === self::TYPE_ADD) {
                $this->putUUID($d[0]);
                $this->putLong($d[1]);
                $this->putString($d[2]);
                $this->putString($d[3]);
                $this->putString($d[4]);
            } else {
                $this->putUUID($d[0]);
            }
        }
    }

}
