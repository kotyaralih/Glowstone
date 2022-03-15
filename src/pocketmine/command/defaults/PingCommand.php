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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class PingCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.ping.description",
            "%commands.ping.usage",
            ["connection"]
        );
        $this->setPermission("pocketmine.command.ping");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!($this->testPermission($sender))) {
            return false;
        }

        if (!($sender instanceof Player)) {
            $sender->sendMessage("Only in-game!");
            return true;
        }

        if (!(isset($args[0]))) {
            $sender->sendMessage("Ping: " . $sender->getPing() . "ms");
            return true;
        } else {
            $target = Server::getInstance()->getPlayer($args[0]);

            if ($target == null) {
                return $sender->sendMessage(TextFormat::RED . "Player not found");
            }

            $sender->sendMessage($target->getName() . "'s ping: " . $target->getPing() . "ms");
        }
        return false;
    }
}
