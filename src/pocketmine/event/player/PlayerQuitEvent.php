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

use pocketmine\Player;

/**
 * Called when a player leaves the server
 */
class PlayerQuitEvent extends PlayerEvent
{
    public static $handlerList = null;

    /** @var string */
    protected $quitMessage;
    protected $autoSave = true;

    public function __construct(Player $player, $quitMessage, $autoSave = true)
    {
        $this->player = $player;
        $this->quitMessage = $quitMessage;
        $this->autoSave = $autoSave;
    }

    public function setQuitMessage($quitMessage)
    {
        $this->quitMessage = $quitMessage;
    }

    public function getQuitMessage()
    {
        return $this->quitMessage;
    }

    public function getAutoSave()
    {
        return $this->autoSave;
    }

    public function setAutoSave($value = true)
    {
        $this->autoSave = (bool)$value;
    }

}