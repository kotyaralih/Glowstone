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

abstract class Task
{

    /** @var TaskHandler */
    private $taskHandler = null;

    /**
     * @return TaskHandler
     */
    public final function getHandler()
    {
        return $this->taskHandler;
    }

    /**
     * @return int
     */
    public final function getTaskId()
    {
        if ($this->taskHandler !== null) {
            return $this->taskHandler->getTaskId();
        }

        return -1;
    }

    /**
     * @param TaskHandler $taskHandler
     */
    public final function setHandler($taskHandler)
    {
        if ($this->taskHandler === null or $taskHandler === null) {
            $this->taskHandler = $taskHandler;
        }
    }

    /**
     * Actions to execute when run
     *
     * @param $currentTick
     *
     * @return void
     */
    public abstract function onRun($currentTick);

    /**
     * Actions to execute if the Task is cancelled
     */
    public function onCancel()
    {

    }

}
