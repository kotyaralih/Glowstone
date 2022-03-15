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

use pocketmine\command\CommandSender;
use pocketmine\event\Cancellable;

/**
 * Called when the console runs a command, early in the process
 *
 * You don't want to use this except for a few cases like logging commands,
 * blocking commands on certain places, or applying modifiers.
 *
 * The message contains a slash at the start
 */
class ServerCommandEvent extends ServerEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var string */
    protected $command;

    /** @var CommandSender */
    protected $sender;

    /**
     * @param CommandSender $sender
     * @param string $command
     */
    public function __construct(CommandSender $sender, $command)
    {
        $this->sender = $sender;
        $this->command = $command;
    }

    /**
     * @return CommandSender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

}