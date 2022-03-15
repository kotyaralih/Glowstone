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

namespace pocketmine\plugin;

use pocketmine\event\Event;
use pocketmine\event\Listener;

class MethodEventExecutor implements EventExecutor
{

    private $method;

    public function __construct($method)
    {
        $this->method = $method;
    }

    public function execute(Listener $listener, Event $event)
    {
        $listener->{$this->getMethod()}($event);
    }

    public function getMethod()
    {
        return $this->method;
    }
}