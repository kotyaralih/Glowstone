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

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerBucketEmptyEvent extends PlayerBucketEvent
{
    public static $handlerList = null;

    public function __construct(Player $who, Block $blockClicked, $blockFace, Item $bucket, Item $itemInHand)
    {
        parent::__construct($who, $blockClicked, $blockFace, $bucket, $itemInHand);
    }
}