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

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\TimingsHandler;

class RegisteredListener
{

    /** @var Listener */
    private $listener;

    /** @var int */
    private $priority;

    /** @var Plugin */
    private $plugin;

    /** @var EventExecutor */
    private $executor;

    /** @var bool */
    private $ignoreCancelled;

    /** @var TimingsHandler */
    private $timings;


    /**
     * @param Listener $listener
     * @param EventExecutor $executor
     * @param int $priority
     * @param Plugin $plugin
     * @param boolean $ignoreCancelled
     * @param TimingsHandler $timings
     */
    public function __construct(Listener $listener, EventExecutor $executor, $priority, Plugin $plugin, $ignoreCancelled, TimingsHandler $timings)
    {
        $this->listener = $listener;
        $this->priority = $priority;
        $this->plugin = $plugin;
        $this->executor = $executor;
        $this->ignoreCancelled = $ignoreCancelled;
        $this->timings = $timings;
    }

    /**
     * @return Listener
     */
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * @return Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Event $event
     */
    public function callEvent(Event $event)
    {
        if ($event instanceof Cancellable and $event->isCancelled() and $this->isIgnoringCancelled()) {
            return;
        }
        $this->timings->startTiming();
        $this->executor->execute($this->listener, $event);
        $this->timings->stopTiming();
    }

    public function __destruct()
    {
        $this->timings->remove();
    }

    /**
     * @return bool
     */
    public function isIgnoringCancelled()
    {
        return $this->ignoreCancelled === true;
    }
}