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

class Ghast extends FlyingAnimal
{
    const NETWORK_ID = 41;

    public $width = 6;
    public $length = 6;
    public $height = 6;

    public function getName(): string
    {
        return "Ghast";
    }

    public function initEntity()
    {
        $this->setMaxHealth(10);
        parent::initEntity();
    }

    public function spawnTo(Player $player)
    {
        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = Ghast::NETWORK_ID;
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