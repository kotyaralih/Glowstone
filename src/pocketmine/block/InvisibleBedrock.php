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

class InvisibleBedrock extends Transparent
{

	protected $id = self::INVISIBLE_BEDROCK;

    /**
     * @param $meta
     */
    public function __construct($meta = 0)
    {
		$this->meta = $meta;
	}

	/**
	 * @return string
	 */
	public function getName(): string
    {
		return "Invisible Bedrock";
	}

	/**
	 * @return int
	 */
	public function getHardness()
    {
		return -1;
	}

	/**
	 * @return int
	 */
	public function getResistance()
    {
		return 18000000;
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isBreakable(Item $item)
    {
		return false;
	}
}
