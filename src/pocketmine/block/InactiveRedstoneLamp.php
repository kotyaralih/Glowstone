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

class InactiveRedstoneLamp extends ActiveRedstoneLamp
{
    protected $id = self::INACTIVE_REDSTONE_LAMP;

    public function getLightLevel()
    {
        return 0;
    }

    public function getName(): string
    {
        return "Inactive Redstone Lamp";
    }

    public function isLightedByAround()
    {
        return false;
    }

    public function turnOn()
    {
        //if($isLightedByAround){
        $this->getLevel()->setBlock($this, new ActiveRedstoneLamp(), true, false);
        /*}else{
            $this->getLevel()->setBlock($this, new ActiveRedstoneLamp(), true, false);
            //$this->lightAround();
        }*/
        return true;
    }

    public function turnOff()
    {
        return true;
    }
}