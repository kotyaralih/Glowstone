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

use pocketmine\network\protocol\DataPacket;
use pocketmine\Player;

/**
 * Classes that implement this interface will be able to be attached to players
 */
interface SourceInterface
{

    /**
     * Sends a DataPacket to the interface, returns an unique identifier for the packet if $needACK is true
     *
     * @param Player $player
     * @param DataPacket $packet
     * @param bool $needACK
     * @param bool $immediate
     *
     * @return int
     */
    public function putPacket(Player $player, DataPacket $packet, $needACK = false, $immediate = true);

    /**
     * Terminates the connection
     *
     * @param Player $player
     * @param string $reason
     *
     */
    public function close(Player $player, $reason = "unknown reason");

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return bool
     */
    public function process();

    public function shutdown();

    public function emergencyShutdown();

}