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

class PardonCidCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.unban.cid.description",
            "%commands.unbancid.usage"
        );
        $this->setPermission("pocketmine.command.pardoncid");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) !== 1) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
            return false;
        }

        $sender->getServer()->getCIDBans()->remove($args[0]);

        Command::broadcastCommandMessage($sender, new TranslationContainer("commands.unban.success", [$args[0]]));
        return true;
    }
}
