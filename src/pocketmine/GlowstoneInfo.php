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

namespace pocketmine;

class GlowstoneInfo
{
    const NAME = "Glowstone";
    const VERSION = "3.4.0";
    const API = "2.0.0";
    const GLOWSTONE_API = "1.0.2";
    const MINECRAFT_VERSION_NETWORK = "0.14.3";

    const CODENAME = "Lunarelly";
    const MINECRAFT_VERSION = "v0.14";

    /**
     * @return string
     */
    public static function getGlowstoneInfo(): string
    {
        return "Glowstone. Made by Lunarelly for MCPE 0.14";
    }
}