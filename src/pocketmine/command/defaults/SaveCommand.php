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


class SaveCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.save.description",
            "%commands.save.usage"
        );
        $this->setPermission("pocketmine.command.save.perform");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        Command::broadcastCommandMessage($sender, new TranslationContainer("commands.save.start"));

        foreach ($sender->getServer()->getOnlinePlayers() as $player) {
            $player->save();
        }

        foreach ($sender->getServer()->getLevels() as $level) {
            $level->save(true);
        }

        Command::broadcastCommandMessage($sender, new TranslationContainer("commands.save.success"));

        return true;
    }
}