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
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

abstract class PlayerBucketEvent extends PlayerEvent implements Cancellable
{

    /** @var Block */
    private $blockClicked;
    /** @var int */
    private $blockFace;
    /** @var Item */
    private $bucket;
    /** @var Item */
    private $item;

    /**
     * @param Player $who
     * @param Block $blockClicked
     * @param int $blockFace
     * @param Item $bucket
     * @param Item $itemInHand
     */
    public function __construct(Player $who, Block $blockClicked, $blockFace, Item $bucket, Item $itemInHand)
    {
        $this->player = $who;
        $this->blockClicked = $blockClicked;
        $this->blockFace = (int)$blockFace;
        $this->item = $itemInHand;
        $this->bucket = $bucket;
    }

    /**
     * Returns the bucket used in this event
     *
     * @return Item
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Returns the item in hand after the event
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return Block
     */
    public function getBlockClicked()
    {
        return $this->blockClicked;
    }

    /**
     * @return int
     */
    public function getBlockFace()
    {
        return $this->blockFace;
    }
}