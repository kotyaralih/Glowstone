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
use pocketmine\Player;

/**
 * Called when a sign is changed by a player.
 */
class SignChangeEvent extends BlockEvent implements Cancellable
{
    public static $handlerList = null;

    /** @var \pocketmine\Player */
    private $player;
    /** @var string[] */
    private $lines = [];

    /**
     * @param Block $theBlock
     * @param Player $thePlayer
     * @param string[] $theLines
     */
    public function __construct(Block $theBlock, Player $thePlayer, array $theLines)
    {
        parent::__construct($theBlock);
        $this->player = $thePlayer;
        $this->lines = $theLines;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return string[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param int $index 0-3
     *
     * @return string
     */
    public function getLine($index)
    {
        return $this->lines[$index];
    }

    /**
     * @param int $index 0-3
     * @param string $line
     */
    public function setLine($index, $line)
    {
        $this->lines[$index] = $line;
    }
}