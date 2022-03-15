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

namespace pocketmine\event;


use InvalidArgumentException;

/**
 * List of event priorities
 *
 * Events will be called in this order:
 * LOWEST -> LOW -> NORMAL -> HIGH -> HIGHEST -> MONITOR
 *
 * MONITOR events should not change the event outcome or contents
 */
abstract class EventPriority
{
    /**
     * List of event priorities in an array
     */
    const ALL = [
        self::LOWEST,
        self::LOW,
        self::NORMAL,
        self::HIGH,
        self::HIGHEST,
        self::MONITOR
    ];

    /**
     * Event call is of very low importance and should be ran first, to allow
     * other plugins to further customise the outcome
     */
    const LOWEST = 5;
    /**
     * Event call is of low importance
     */
    const LOW = 4;
    /**
     * Event call is neither important or unimportant, and may be ran normally
     */
    const NORMAL = 3;
    /**
     * Event call is of high importance
     */
    const HIGH = 2;
    /**
     * Event call is critical and must have the final say in what happens
     * to the event
     */
    const HIGHEST = 1;
    /**
     * Event is listened to purely for monitoring the outcome of an event.
     *
     * No modifications to the event should be made under this priority
     */
    const MONITOR = 0;

    /**
     * @param string $name
     *
     * @return int
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $name) : int
    {
        $name = strtoupper($name);
        $const = self::class . "::" . $name;
        if($name !== "ALL" and \defined($const)){
            return \constant($const);
        }

        throw new InvalidArgumentException("Unable to resolve priority \"$name\"");
    }

}