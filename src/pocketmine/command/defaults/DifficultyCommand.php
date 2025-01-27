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
use pocketmine\network\protocol\SetDifficultyPacket;
use pocketmine\Server;


class DifficultyCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.difficulty.description",
            "%commands.difficulty.usage"
        );
        $this->setPermission("pocketmine.command.difficulty");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) !== 1) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return false;
        }

        $difficulty = Server::getDifficultyFromString($args[0]);

        if ($sender->getServer()->isHardcore()) {
            $difficulty = 3;
        }

        if ($difficulty !== -1) {
            $sender->getServer()->setConfigInt("difficulty", $difficulty);

            $pk = new SetDifficultyPacket();
            $pk->difficulty = $sender->getServer()->getDifficulty();
            Server::broadcastPacket($sender->getServer()->getOnlinePlayers(), $pk);

            Command::broadcastCommandMessage($sender, new TranslationContainer("commands.difficulty.success", [$difficulty]));
        } else {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return false;
        }

        return true;
    }
}