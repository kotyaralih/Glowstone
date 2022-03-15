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

namespace pocketmine\item\enchantment;


class EnchantmentEntry
{

    /** @var Enchantment[] */
    private $enchantments;
    private $cost;
    private $randomName;

    /**
     * @param Enchantment[] $enchantments
     * @param $cost
     * @param $randomName
     */
    public function __construct(array $enchantments, $cost, $randomName)
    {
        $this->enchantments = $enchantments;
        $this->cost = (int)$cost;
        $this->randomName = $randomName;
    }

    public function getEnchantments()
    {
        return $this->enchantments;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getRandomName()
    {
        return $this->randomName;
    }

}