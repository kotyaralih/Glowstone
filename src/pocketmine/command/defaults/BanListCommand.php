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
use pocketmine\event\TranslationContainer;
use pocketmine\Server;
use function count;
use function strtolower;
use function substr;


class BanListCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.banlist.description",
            "%commands.banlist.usage"
        );
        $this->setPermission("pocketmine.command.ban.list");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return true;
        }
        $list = $sender->getServer()->getNameBans();
        if (isset($args[0])) {
            $args[0] = strtolower($args[0]);
            if ($args[0] === "ips") {
                $list = $sender->getServer()->getIPBans();
            } elseif ($args[0] === "players") {
                $list = $sender->getServer()->getNameBans();
            } elseif ($args[0] === "cids") {
                $list = $sender->getServer()->getCIDBans();
            } else {
                $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

                return false;
            }
        }

        $message = "";
        $list = $list->getEntries();
        foreach ($list as $entry) {
            $message .= $entry->getName() . ", ";
        }

        if (!isset($args[0])) return false;
        if ($args[0] === "ips") {
            $sender->sendMessage(Server::getInstance()->getLanguage()->translateString("commands.banlist.ips", [count($list)]));
        } elseif ($args[0] === "players") {
            $sender->sendMessage(Server::getInstance()->getLanguage()->translateString("commands.banlist.players", [count($list)]));
        } else $sender->sendMessage("list " . count($list) . "ban");

        $sender->sendMessage(substr($message, 0, -2));

        return true;
    }
}