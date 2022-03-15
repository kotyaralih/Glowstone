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

/**
 * Network-related classes
 */

namespace pocketmine\network;

interface AdvancedSourceInterface extends SourceInterface
{

    /**
     * @param string $address
     * @param int $timeout Seconds
     */
    public function blockAddress($address, $timeout = 300);

    /**
     * @param Network $network
     */
    public function setNetwork(Network $network);

    /**
     * @param string $address
     * @param int $port
     * @param string $payload
     */
    public function sendRawPacket($address, $port, $payload);

}