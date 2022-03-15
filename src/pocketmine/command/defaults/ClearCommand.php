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
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class ClearCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.clear.description",
            "/clear <all|armor> <player>",
            ["clearinventory"]
        );
        $this->setPermission("pocketmine.command.clear");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!($this->testPermission($sender))) {
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage("Usage: " . $this->usageMessage);
            return true;
        }

        $player = Server::getInstance()->getPlayer($args[1]);

        if ($player === null) {
            $sender->sendMessage(TextFormat::RED . "Player not found");
            return true;
        }

        $inventory = $player->getInventory();

        switch ($args[0]) {
            case "all":
                $inventory->clearAll();

                $player->sendMessage("Your inventory have been cleared!");
                $sender->sendMessage("You have cleared " . $player->getName() . "'s inventory!");
                break;

            case "armor":
                $inventory->setHelmet(Item::get(Item::AIR, 0, 0));
                $inventory->setChestplate(Item::get(Item::AIR, 0, 0));
                $inventory->setLeggings(Item::get(Item::AIR, 0, 0));
                $inventory->setBoots(Item::get(Item::AIR, 0, 0));

                $player->sendMessage("Your armor inventory have been cleared!");
                $sender->sendMessage("You have cleared " . $player->getName() . "'s armor inventory!");
                break;

            default:
                $sender->sendMessage("Usage: " . $this->usageMessage);
                break;
        }
        return true;
    }
}