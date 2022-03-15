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

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;

class Mooshroom extends Animal
{
    const NETWORK_ID = 16;

    public $width = 0.3;
    public $length = 0.9;
    public $height = 1.8;

    public function getName(): string
    {
        return "Mooshroom";
    }

    public function spawnTo(Player $player)
    {
        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = Mooshroom::NETWORK_ID;
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

    public function getDrops()
    {
        $drops = array(ItemItem::get(ItemItem::RED_MUSHROOM, 0, 2));
        if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player) {
            if (\mt_rand(0, 199) < 5) {
                switch (\mt_rand(0, 2)) {
                    case 0:
                        $drops[] = ItemItem::get(ItemItem::BROWN_MUSHROOM, 0, 1);
                        break;
                    case 1:
                        $drops[] = ItemItem::get(ItemItem::CARROT, 0, 1);
                        break;
                    case 2:
                        $drops[] = ItemItem::get(ItemItem::POTATO, 0, 1);
                        break;
                }
            }
        }
        return $drops;
    }
}
