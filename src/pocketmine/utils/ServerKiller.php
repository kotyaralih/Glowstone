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

namespace pocketmine\utils;

use pocketmine\Thread;

class ServerKiller extends Thread
{

    public $time;

    public function __construct($time = 15)
    {
        $this->time = $time;
    }

    public function run()
    {
        $start = time() + 1;
        $this->synchronized(function () {
            $this->wait($this->time * 1000000);
        });
        if (time() - $start >= $this->time) {
            echo "\nTook too long to stop, server was killed forcefully!\n";
            @\pocketmine\kill(getmypid());
        }
    }

    public function getThreadName()
    {
        return "Server Killer";
    }
}
