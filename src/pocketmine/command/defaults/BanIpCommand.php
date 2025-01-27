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
use pocketmine\Player;


class BanIpCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.ban.ip.description",
            "%commands.banip.usage"
        );
        $this->setPermission("pocketmine.command.ban.ip");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return false;
        }

        $value = array_shift($args);
        $reason = implode(" ", $args);

        if (preg_match("/^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])$/", $value)) {
            $this->processIPBan($value, $sender, $reason);

            Command::broadcastCommandMessage($sender, new TranslationContainer("commands.banip.success", [$value]));
        } else {
            if (($player = $sender->getServer()->getPlayer($value)) instanceof Player) {
                $this->processIPBan($player->getAddress(), $sender, $reason);

                Command::broadcastCommandMessage($sender, new TranslationContainer("commands.banip.success.players", [$player->getAddress(), $player->getName()]));
            } else {
                $sender->sendMessage(new TranslationContainer("commands.banip.invalid"));

                return false;
            }
        }

        return true;
    }

    private function processIPBan(string $ip, CommandSender $sender, string $reason)
    {
        $sender->getServer()->getIPBans()->addBan($ip, $reason, null, $sender->getName());

        foreach ($sender->getServer()->getOnlinePlayers() as $player) {
            if ($player->getAddress() === $ip) {
                $player->kick($reason !== "" ? $reason : "IP banned.");
            }
        }
    }
}