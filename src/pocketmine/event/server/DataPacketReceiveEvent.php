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

namespace pocketmine\event\server;

use pocketmine\event\Cancellable;
use pocketmine\network\protocol\DataPacket;
use pocketmine\Player;

class DataPacketReceiveEvent extends ServerEvent implements Cancellable
{
    public static $handlerList = null;

    private $packet;
    private $player;

    public function __construct(Player $player, DataPacket $packet)
    {
        $this->packet = $packet;
        $this->player = $player;
    }

    public function getPacket()
    {
        return $this->packet;
    }

    public function getPlayer()
    {
        return $this->player;
    }
}