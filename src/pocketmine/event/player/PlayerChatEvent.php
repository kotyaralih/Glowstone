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
use pocketmine\Server;

/**
 * Called when a player chats something
 */
class PlayerChatEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var string */
    protected $message;

    /** @var string */
    protected $format;

    /**
     * @var Player[]
     */
    protected $recipients = [];

    public function __construct(Player $player, $message, $format = "chat.type.text", array $recipients = null)
    {
        $this->player = $player;
        $this->message = $message;

        //TODO: @deprecated (backwards-compativility)
        $i = 0;
        while (($pos = strpos($format, "%s")) !== false) {
            $format = substr($format, 0, $pos) . "{%$i}" . substr($format, $pos + 2);
            ++$i;
        }

        $this->format = $format;

        if ($recipients === null) {
            $this->recipients = Server::getInstance()->getPluginManager()->getPermissionSubscriptions(Server::BROADCAST_CHANNEL_USERS);
        } else {
            $this->recipients = $recipients;
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Changes the player that is sending the message
     *
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        //TODO: @deprecated (backwards-compativility)
        $i = 0;
        while (($pos = strpos($format, "%s")) !== false) {
            $format = substr($format, 0, $pos) . "{%$i}" . substr($format, $pos + 2);
            ++$i;
        }

        $this->format = $format;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;
    }
}