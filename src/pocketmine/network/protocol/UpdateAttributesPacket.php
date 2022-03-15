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
use pocketmine\entity\Attribute;

class UpdateAttributesPacket extends DataPacket
{
    const NETWORK_ID = Info::UPDATE_ATTRIBUTES_PACKET;
    public $entityId;
    /** @var Attribute[] */
    public $entries = [];

    public function decode()
    {
    }

    public function encode()
    {
        $this->reset();
        $this->putLong($this->entityId);
        $this->putShort(count($this->entries));
        foreach ($this->entries as $entry) {
            $this->putFloat($entry->getMinValue());
            $this->putFloat($entry->getMaxValue());
            $this->putFloat($entry->getValue());
            $this->putString($entry->getName());
        }
    }
}