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

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\Player;

class StoneButton extends WoodenButton
{
    protected $id = self::STONE_BUTTON;

    public function getName(): string
    {
        return "Stone Button";
    }

    public function onActivate(Item $item, Player $player = null)
    {
        if (!$this->isActivated()) {
            $this->meta ^= 0x08;
            $this->getLevel()->setBlock($this, $this, true, false);
            $this->getLevel()->addSound(new ButtonClickSound($this));
            $this->activate();
            $this->getLevel()->scheduleUpdate($this, 40);
        }
        return true;
    }
}
