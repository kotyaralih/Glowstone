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

namespace pocketmine\item;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityEatItemEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\Player;
use pocketmine\Server;

abstract class Food extends Item implements FoodSource
{
    public function canBeConsumed(): bool
    {
        return true;
    }

    public function canBeConsumedBy(Entity $entity): bool
    {
        return $entity instanceof Human and $entity->getFood() < $entity->getMaxFood();
    }

    public function getResidue()
    {
        if ($this->getCount() === 1) {
            return Item::get(0);
        } else {
            $new = clone $this;
            $new->count--;
            return $new;
        }
    }

    public function getAdditionalEffects(): array
    {
        return [];
    }

    public function onConsume(Entity $human)
    {
        $pk = new EntityEventPacket();
        $pk->eid = $human->getId();
        $pk->event = EntityEventPacket::USE_ITEM;
        if ($human instanceof Player) {
            $human->dataPacket($pk);
        }
        Server::broadcastPacket($human->getViewers(), $pk);

        $ev = new EntityEatItemEvent($human, $this);

        $human->addSaturation($ev->getSaturationRestore());
        $human->addFood($ev->getFoodRestore());
        foreach ($ev->getAdditionalEffects() as $effect) {
            $human->addEffect($effect);
        }

        $human->getInventory()->setItemInHand($ev->getResidue());
    }
}
