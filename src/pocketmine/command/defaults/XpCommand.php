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
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class XpCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.xp.description",
            "%commands.xp.usage"
        );
        $this->setPermission("pocketmine.command.xp");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) != 2) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
            return false;
        } else {
            $player = $sender->getServer()->getPlayerExact($name = $args[1]);
            if ($player instanceof Player) {
                if (strcasecmp(substr($args[0], -1), "L") == 0) {            //Set Experience Level(with "L" after args[0])
                    $level = rtrim($args[0], "Ll");
                    if (is_numeric($level)) {
                        $player->addExpLevel($level);
                        $sender->sendMessage("Successfully added $level Level of experience to $name");
                    }
                } elseif (is_numeric($args[0])) {                                            //Set Experience
                    $player->addExperience($args[0]);
                    $sender->sendMessage("Successfully added $args[0] of experience to $name");
                } else {
                    $sender->sendMessage("Argument error");
                    return false;
                }
            } else {
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
                return false;
            }
        }
        return false;
    }
}
