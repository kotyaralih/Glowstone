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
use pocketmine\item\enchantment\Enchantment;
use pocketmine\utils\TextFormat;

class EnchantCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.enchant.description",
            "%commands.enchant.usage"
        );
        $this->setPermission("pocketmine.command.enchant");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) < 2) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return true;
        }

        $player = $sender->getServer()->getPlayer($args[0]);

        if ($player === null) {
            $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
            return true;
        }

        $enchantId = (int)$args[1];
        $enchantLevel = isset($args[2]) ? (int)$args[2] : 1;

        $enchantment = Enchantment::getEnchantment($enchantId);
        if ($enchantment->getId() === Enchantment::TYPE_INVALID) {
            $sender->sendMessage(new TranslationContainer("commands.enchant.notFound", [$enchantId]));
            return true;
        }

        $enchantment->setLevel($enchantLevel);

        $item = $player->getInventory()->getItemInHand();

        if ($item->getId() <= 0) {
            $sender->sendMessage(new TranslationContainer("commands.enchant.noItem"));
            return true;
        }

        $item->addEnchantment($enchantment);
        $player->getInventory()->setItemInHand($item);


        self::broadcastCommandMessage($sender, new TranslationContainer("%commands.enchant.success"));
        return true;
    }
}