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

#ifndef COMPILE

#endif


use pocketmine\utils\BinaryStream;
use pocketmine\utils\Utils;


abstract class DataPacket extends BinaryStream
{

    const NETWORK_ID = 0;

    public $isEncoded = false;
    private $channel = 0;

    public function pid()
    {
        return $this::NETWORK_ID;
    }

    abstract public function encode();

    abstract public function decode();

    public function reset()
    {
        $this->buffer = chr($this::NETWORK_ID);
        $this->offset = 0;
    }

    /**
     * This adds extra overhead on the network, so its usage is now discouraged. It was a test for the viability of this.
     */
    public function setChannel($channel)
    {
        $this->channel = (int)$channel;
        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function clean()
    {
        $this->buffer = null;
        $this->isEncoded = false;
        $this->offset = 0;
        return $this;
    }

    public function __debugInfo()
    {
        $data = [];
        foreach ($this as $k => $v) {
            if ($k === "buffer") {
                $data[$k] = bin2hex($v);
            } elseif (is_string($v) or (is_object($v) and method_exists($v, "__toString"))) {
                $data[$k] = Utils::printable((string)$v);
            } else {
                $data[$k] = $v;
            }
        }

        return $data;
    }
}
