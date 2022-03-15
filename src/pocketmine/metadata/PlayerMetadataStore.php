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

namespace pocketmine\metadata;

use pocketmine\IPlayer;

class PlayerMetadataStore extends MetadataStore
{

    public function disambiguate(Metadatable $player, $metadataKey)
    {
        if (!($player instanceof IPlayer)) {
            throw new \InvalidArgumentException("Argument must be an IPlayer instance");
        }

        return strtolower($player->getName()) . ":" . $metadataKey;
    }
}
