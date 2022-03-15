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

use pocketmine\level\Position;
use pocketmine\Player;

class AnvilInventory extends ContainerInventory
{
    public function __construct(Position $pos)
    {
        parent::__construct(new FakeBlockMenu($this, $pos), InventoryType::get(InventoryType::ANVIL));
    }

    /**
     * @return FakeBlockMenu
     */
    public function getHolder()
    {
        return $this->holder;
    }

    public function onClose(Player $who)
    {
        $who->updateExperience();
        parent::onClose($who);

        $this->getHolder()->getLevel()->dropItem($this->getHolder()->add(0.5, 0.5, 0.5), $this->getItem(1));
        $this->getHolder()->getLevel()->dropItem($this->getHolder()->add(0.5, 0.5, 0.5), $this->getItem(0));

        $this->clear(0);
        $this->clear(1);
        $this->clear(2);
    }

}