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

namespace pocketmine\entity;

use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;

class LavaSlime extends Living
{
    const NETWORK_ID = 42;

    const DATA_SLIME_SIZE = 16;

    public $dropExp = [1, 4];

    public function getName(): string
    {
        return "LavaSlime";
    }

    public function spawnTo(Player $player)
    {
        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = LavaSlime::NETWORK_ID;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->speedX = $this->motionX;
        $pk->speedY = $this->motionY;
        $pk->speedZ = $this->motionZ;
        $pk->yaw = $this->yaw;
        $pk->pitch = $this->pitch;
        $pk->metadata = $this->dataProperties;
        $player->dataPacket($pk);

        parent::spawnTo($player);
    }
}