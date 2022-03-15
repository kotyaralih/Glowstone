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

class FileWriteTask extends AsyncTask
{

    private $path;
    private $contents;
    private $flags;

    public function __construct($path, $contents, $flags = 0)
    {
        $this->path = $path;
        $this->contents = $contents;
        $this->flags = (int)$flags;
    }

    public function onRun()
    {
        try {
            file_put_contents($this->path, $this->contents, (int)$this->flags);
        } catch (\Throwable $e) {

        }
    }
}
