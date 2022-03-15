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

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class BlockBreakEvent extends BlockEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var \pocketmine\Player */
    protected $player;

    /** @var \pocketmine\item\Item */
    protected $item;

    /** @var bool */
    protected $instaBreak = false;
    protected $blockDrops = [];

    public function __construct(Player $player, Block $block, Item $item, $instaBreak = false)
    {
        $this->block = $block;
        $this->item = $item;
        $this->player = $player;
        $this->instaBreak = (bool)$instaBreak;
        $drops = $player->isSurvival() ? $block->getDrops($item) : [];
        if ($drops != null && is_numeric($drops[0]))
            $this->blockDrops[] = Item::get($drops[0], $drops[1], $drops[2]);
        else
            foreach ($drops as $i) {
                $this->blockDrops[] = Item::get($i[0], $i[1], $i[2]);
            }
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getInstaBreak()
    {
        return $this->instaBreak;
    }

    /**
     * @return Item[]
     */
    public function getDrops()
    {
        return $this->blockDrops;
    }

    /**
     * @param Item[] $drops
     */
    public function setDrops(array $drops)
    {
        $this->blockDrops = $drops;
    }

    /**
     * @param boolean $instaBreak
     */
    public function setInstaBreak($instaBreak)
    {
        $this->instaBreak = (bool)$instaBreak;
    }
}
