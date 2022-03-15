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

namespace pocketmine\inventory;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\ContainerClosePacket;
use pocketmine\network\protocol\ContainerOpenPacket;
use pocketmine\Player;

abstract class ContainerInventory extends BaseInventory
{
    public function onOpen(Player $who)
    {
        parent::onOpen($who);
        $pk = new ContainerOpenPacket();
        $pk->windowid = $who->getWindowId($this);
        $pk->type = $this->getType()->getNetworkType();
        $pk->slots = $this->getSize();
        $holder = $this->getHolder();
        if ($holder instanceof Vector3) {
            $pk->x = $holder->getX();
            $pk->y = $holder->getY();
            $pk->z = $holder->getZ();
        } else {
            $pk->x = $pk->y = $pk->z = 0;
        }

        $who->dataPacket($pk);

        $this->sendContents($who);
    }

    public function onClose(Player $who)
    {
        $pk = new ContainerClosePacket();
        $pk->windowid = $who->getWindowId($this);
        $who->dataPacket($pk);
        parent::onClose($who);
    }
}