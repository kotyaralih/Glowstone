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
use pocketmine\utils\TextFormat;
use function memory_get_usage;
use function number_format;
use function round;


class GarbageCollectorCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.gc.description",
            "%pocketmine.command.gc.usage",
            ["gc"]
        );
        $this->setPermission("pocketmine.command.gc");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        $chunksCollected = 0;
        $entitiesCollected = 0;
        $tilesCollected = 0;

        $memory = memory_get_usage();

        foreach ($sender->getServer()->getLevels() as $level) {
            $diff = [count($level->getChunks()), count($level->getEntities()), count($level->getTiles())];
            $level->doChunkGarbageCollection();
            $level->unloadChunks(true);
            $chunksCollected += $diff[0] - count($level->getChunks());
            $entitiesCollected += $diff[1] - count($level->getEntities());
            $tilesCollected += $diff[2] - count($level->getTiles());
            $level->clearCache(true);
        }

        $cyclesCollected = $sender->getServer()->getMemoryManager()->triggerGarbageCollector();
        $sender->sendMessage(TextFormat::GREEN . "---- " . TextFormat::WHITE . "%pocketmine.command.gc.title" . TextFormat::GREEN . " ----");
        $sender->sendMessage(TextFormat::GOLD . "%pocketmine.command.gc.chunks" . TextFormat::RED . " " . number_format($chunksCollected));
        $sender->sendMessage(TextFormat::GOLD . "%pocketmine.command.gc.entities" . TextFormat::RED . " " . number_format($entitiesCollected));
        $sender->sendMessage(TextFormat::GOLD . "%pocketmine.command.gc.tiles" . TextFormat::RED . " " . number_format($tilesCollected));
        $sender->sendMessage(TextFormat::GOLD . "%pocketmine.command.gc.cycles" . TextFormat::RED . " " . number_format($cyclesCollected));
        $sender->sendMessage(TextFormat::GOLD . "%pocketmine.command.gc.memory" . TextFormat::RED . " " . number_format(round((($memory - memory_get_usage()) / 1024) / 1024, 2)) . " MB");
        return true;
    }
}
