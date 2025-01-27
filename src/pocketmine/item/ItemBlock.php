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

use pocketmine\block\Block;

/**
 * Class used for Items that can be Blocks
 */
class ItemBlock extends Item
{
    public function __construct(Block $block, $meta = 0, int $count = 1)
    {
        $this->block = $block;
        parent::__construct($block->getId(), $block->getDamage(), $count, $block->getName());
    }

    public function setDamage($meta)
    {
        $this->meta = $meta !== null ? $meta & 0xf : null;
        $this->block->setDamage($this->meta);
    }

    public function __clone()
    {
        $this->block = clone $this->block;
    }

    public function getBlock(): Block
    {
        return $this->block;
    }

}