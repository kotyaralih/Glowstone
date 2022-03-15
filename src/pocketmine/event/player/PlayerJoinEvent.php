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

namespace pocketmine\event\player;

use pocketmine\event\TextContainer;
use pocketmine\Player;

/**
 * Called when a player joins the server, after sending all the spawn packets
 */
class PlayerJoinEvent extends PlayerEvent
{
    public static $handlerList = null;

    /** @var string|TextContainer */
    protected $joinMessage;

    public function __construct(Player $player, $joinMessage)
    {
        $this->player = $player;
        $this->joinMessage = $joinMessage;
    }

    /**
     * @param string|TextContainer $joinMessage
     */
    public function setJoinMessage($joinMessage)
    {
        $this->joinMessage = $joinMessage;
    }

    /**
     * @return string|TextContainer
     */
    public function getJoinMessage()
    {
        return $this->joinMessage;
    }

}