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

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\protocol\AddPaintingPacket;
use pocketmine\Player;

class Painting extends Hanging
{
    const NETWORK_ID = 83;

    private $motive;

    public function initEntity()
    {
        $this->setMaxHealth(1);
        parent::initEntity();

        if (isset($this->namedtag->Motive)) {
            $this->motive = $this->namedtag["Motive"];
        } else $this->close();
    }

    public function attack($damage, EntityDamageEvent $source)
    {
        parent::attack($damage, $source);

        $this->close();
    }

    public function spawnTo(Player $player)
    {
        $pk = new AddPaintingPacket();
        $pk->eid = $this->getId();
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->direction = $this->getDirection();
        $pk->title = $this->motive;
        $player->dataPacket($pk);

        parent::spawnTo($player);
    }

    public function getDrops()
    {
        return [ItemItem::get(ItemItem::PAINTING, 0, 1)];
    }
}