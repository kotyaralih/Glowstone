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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;

class WhitelistCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.whitelist.description",
            "%commands.whitelist.usage",
            ["wl"]
        );
        $this->setPermission("pocketmine.command.whitelist.reload;pocketmine.command.whitelist.enable;pocketmine.command.whitelist.disable;pocketmine.command.whitelist.list;pocketmine.command.whitelist.add;pocketmine.command.whitelist.remove");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0 or count($args) > 2) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
            return true;
        }

        if (count($args) === 1) {
            if ($this->badPerm($sender, strtolower($args[0]))) {
                return false;
            }
            switch (strtolower($args[0])) {
                case "reload":
                    $sender->getServer()->reloadWhitelist();
                    Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.reloaded"));

                    return true;
                case "on":
                    $sender->getServer()->setConfigBool("white-list", true);
                    Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.enabled"));

                    return true;
                case "off":
                    $sender->getServer()->setConfigBool("white-list", false);
                    Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.disabled"));

                    return true;
                case "list":
                    $result = "";
                    $count = 0;
                    foreach ($sender->getServer()->getWhitelisted()->getAll(true) as $player) {
                        $result .= $player . ", ";
                        ++$count;
                    }
                    $sender->sendMessage(new TranslationContainer("commands.whitelist.list", [$count, $count]));
                    $sender->sendMessage(substr($result, 0, -2));

                    return true;

                case "add":
                    $sender->sendMessage(new TranslationContainer("commands.generic.usage", ["%commands.whitelist.add.usage"]));
                    return true;

                case "remove":
                    $sender->sendMessage(new TranslationContainer("commands.generic.usage", ["%commands.whitelist.remove.usage"]));
                    return true;
            }
        } elseif (count($args) === 2) {
            if ($this->badPerm($sender, strtolower($args[0]))) {
                return false;
            }
            switch (strtolower($args[0])) {
                case "add":
                    $sender->getServer()->getOfflinePlayer($args[1])->setWhitelisted(true);
                    Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.add.success", [$args[1]]));

                    return true;
                case "remove":
                    $sender->getServer()->getOfflinePlayer($args[1])->setWhitelisted(false);
                    Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.remove.success", [$args[1]]));

                    return true;
            }
        }

        return true;
    }

    private function badPerm(CommandSender $sender, $perm)
    {
        if (!$sender->hasPermission("pocketmine.command.whitelist.$perm")) {
            $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));

            return true;
        }

        return false;
    }
}
