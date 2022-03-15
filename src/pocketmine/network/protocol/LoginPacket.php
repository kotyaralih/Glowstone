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

class LoginPacket extends DataPacket
{
    const NETWORK_ID = Info::LOGIN_PACKET;

    public $username;
    public $protocol1;
    public $protocol2;
    public $clientId;

    public $clientUUID;
    public $serverAddress;
    public $clientSecret;

    public $skinName = null;
    public $skin = null;

    /**
     * @return void
     */
    public function decode()
    {
        $this->username = $this->getString();

        $this->protocol1 = $this->getInt();
        $this->protocol2 = $this->getInt();

        $this->clientId = $this->getLong();
        $this->clientUUID = $this->getUUID();
        $this->serverAddress = $this->getString();
        $this->clientSecret = $this->getString();

        $this->skinName = $this->getString();
        $this->skin = $this->getString();
    }

    /**
     * @return void
     */
    public function encode()
    {
    }
}