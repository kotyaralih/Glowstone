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

namespace pocketmine\scheduler;

use pocketmine\Worker;

class AsyncWorker extends Worker
{

    private $logger;
    private $id;

    public function __construct(\ThreadedLogger $logger, $id)
    {
        $this->logger = $logger;
        $this->id = $id;
    }

    public function run()
    {
        $this->registerClassLoader();
        gc_enable();
        ini_set("memory_limit", -1);

        global $store;
        $store = [];
    }

    public function handleException(\Throwable $e)
    {
        $this->logger->logException($e);
    }

    public function getThreadName()
    {
        return "Asynchronous Worker #" . $this->id;
    }
}
