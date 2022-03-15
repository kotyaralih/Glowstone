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
use pocketmine\math\Vector3;
use pocketmine\Player;

class SetWorldSpawnCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.setworldspawn.description",
            "%commands.setworldspawn.usage"
        );
        $this->setPermission("pocketmine.command.setworldspawn");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0) {
            if ($sender instanceof Player) {
                $level = $sender->getLevel();
                $pos = (new Vector3($sender->x, $sender->y, $sender->z))->round();
            } else {
                $sender->sendMessage("Only in-game");

                return true;
            }
        } elseif (count($args) === 3) {
            $level = $sender->getServer()->getDefaultLevel();
            $pos = new Vector3($this->getInteger($sender, $args[0]), $this->getInteger($sender, $args[1]), $this->getInteger($sender, $args[2]));
        } else {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return true;
        }

        $level->setSpawnLocation($pos);

        Command::broadcastCommandMessage($sender, new TranslationContainer("commands.setworldspawn.success", [round($pos->x, 2), round($pos->y, 2), round($pos->z, 2)]));

        return true;
    }
}
