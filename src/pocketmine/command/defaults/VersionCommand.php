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
use pocketmine\network\protocol\Info;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class VersionCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.version.description",
            "%pocketmine.command.version.usage",
            ["ver", "about"]
        );
        $this->setPermission("pocketmine.command.version");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0) {
            $sender->sendMessage("§eThis server is running §l§6" . $sender->getServer()->getName() . "§r§e v" . $sender->getServer()->getVersion());
            $sender->sendMessage("§eAuthor: §c" . $sender->getServer()->getCodename());
            $sender->sendMessage("§eAPI: §c" . $sender->getServer()->getApiVersion());
            $sender->sendMessage("§eMCPE Version: §c" . $sender->getServer()->getMinecraftVersion() . " §6(" . Info::CURRENT_PROTOCOL . ")");
            $sender->sendMessage("§ePHP Version: §c" . PHP_VERSION);
            $sender->sendMessage("§eSystem: §c" . $sender->getServer()->getServerOS());
        } else {
            $pluginName = implode(" ", $args);
            $exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);

            if ($exactPlugin instanceof Plugin) {
                $this->describeToSender($exactPlugin, $sender);

                return true;
            }

            $found = false;
            $pluginName = strtolower($pluginName);
            foreach ($sender->getServer()->getPluginManager()->getPlugins() as $plugin) {
                if (stripos($plugin->getName(), $pluginName) !== false) {
                    $this->describeToSender($plugin, $sender);
                    $found = true;
                }
            }

            if (!$found) {
                $sender->sendMessage(new TranslationContainer("pocketmine.command.version.noSuchPlugin"));
            }
        }

        return true;
    }

    private function describeToSender(Plugin $plugin, CommandSender $sender)
    {
        $desc = $plugin->getDescription();
        $sender->sendMessage(TextFormat::DARK_GREEN . $desc->getName() . TextFormat::WHITE . " version " . TextFormat::DARK_GREEN . $desc->getVersion());

        if ($desc->getDescription() != null) {
            $sender->sendMessage($desc->getDescription());
        }

        if ($desc->getWebsite() != null) {
            $sender->sendMessage("Website: " . $desc->getWebsite());
        }

        if (count($authors = $desc->getAuthors()) > 0) {
            if (count($authors) === 1) {
                $sender->sendMessage("Author: " . implode(", ", $authors));
            } else {
                $sender->sendMessage("Authors: " . implode(", ", $authors));
            }
        }
    }
}
