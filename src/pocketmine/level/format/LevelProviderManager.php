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

namespace pocketmine\level\format;

use pocketmine\Server;
use pocketmine\utils\LevelException;

abstract class LevelProviderManager
{
    protected static $providers = [];

    /**
     * @param Server $server
     * @param string $class
     *
     * @throws LevelException
     */
    public static function addProvider(Server $server, $class)
    {
        if (!is_subclass_of($class, LevelProvider::class)) {
            throw new LevelException("Class is not a subclass of LevelProvider");
        }
        /** @var LevelProvider $class */
        self::$providers[strtolower($class::getProviderName())] = $class;
    }

    /**
     * Returns a LevelProvider class for this path, or null
     *
     * @param string $path
     *
     * @return string
     */
    public static function getProvider($path)
    {
        foreach (self::$providers as $provider) {
            /** @var $provider LevelProvider */
            if ($provider::isValid($path)) {
                return $provider;
            }
        }

        return null;
    }

    public static function getProviderByName($name)
    {
        $name = trim(strtolower($name));

        return isset(self::$providers[$name]) ? self::$providers[$name] : null;
    }
}