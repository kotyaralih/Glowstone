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

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerTransferEvent extends PlayerEvent implements Cancellable
{

    /**
     * @var mixed
     */
    public static $handlerList = null;

    /**
     * @var string
     */
    private $address;
    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $message;

    /**
     * @param Player $player
     * @param string $address
     * @param int $port
     * @param string $message
     */
    public function __construct(Player $player, string $address, int $port = 19132, string $message = "")
    {
        $this->player = $player;
        $this->address = $address;
        $this->port = $port;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the message sent to the target player before teleporting.
     * If null or empty, it won't be sent.
     *
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}