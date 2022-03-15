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

class WorldTeleportCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Teleports player to a specified world",
            "/worldtp <world> <player>",
            ["worldteleport", "wtp"]
        );
        $this->setPermission("pocketmine.command.worldteleport");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!($this->testPermission($sender))) {
            return false;
        }

        if (!(isset($args[0]))) {
            $sender->sendMessage("Usage: " . $this->usageMessage);
            return true;
        }

        if (is_dir(getcwd() . "/worlds/" . $args[0])) {
            Server::getInstance()->loadLevel($args[0]);
        }

        $world = Server::getInstance()->getLevelByName($args[0]);

        if (!($world)) {
            $sender->sendMessage(TextFormat::RED . "Can't find world: " . $args[0]);
            return true;
        }

        if ($sender instanceof Player) {
            if (!(isset($args[1]))) {
                $sender->teleport($world->getSpawnLocation());
                return true;
            } else {
                $target = Server::getInstance()->getPlayer($args[1]);

                if ($target === null) {
                    $sender->sendMessage(TextFormat::RED . "Player not found!");
                    return false;
                }

                $target->teleport($world->getSpawnLocation());
                return true;
            }
        } else {
            if (count($args) < 2) {
                $sender->sendMessage("Usage: " . $this->usageMessage);
                return true;
            }

            $target = Server::getInstance()->getPlayer($args[1]);

            if ($target === null) {
                $sender->sendMessage(TextFormat::RED . "Player not found!");
                return true;
            }

            $target->teleport($world->getSpawnLocation());
            return true;
        }
    }
}
