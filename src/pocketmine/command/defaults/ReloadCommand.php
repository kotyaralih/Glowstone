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

class ReloadCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.reload.description",
            "%pocketmine.command.reload.usage"
        );
        $this->setPermission("pocketmine.command.reload");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        Command::broadcastCommandMessage($sender, new TranslationContainer(TextFormat::YELLOW . "%pocketmine.command.reload.reloading"));

        $sender->getServer()->reload();
        Command::broadcastCommandMessage($sender, new TranslationContainer(TextFormat::YELLOW . "%pocketmine.command.reload.reloaded"));

        return true;
    }
}
