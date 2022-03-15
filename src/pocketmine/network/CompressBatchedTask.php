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

namespace pocketmine\network;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class CompressBatchedTask extends AsyncTask
{

    public $level = 7;
    public $data;
    public $final;
    public $targets;

    public function __construct($data, array $targets, $level = 7)
    {
        $this->data = $data;
        $this->targets = serialize($targets);
        $this->level = $level;
    }

    public function onRun()
    {
        try {
            $this->final = zlib_encode($this->data, ZLIB_ENCODING_DEFLATE, $this->level);
            $this->data = null;
        } catch (\Throwable $e) {

        }
    }

    public function onCompletion(Server $server)
    {
        $server->broadcastPacketsCallback($this->final, unserialize($this->targets));
    }
}