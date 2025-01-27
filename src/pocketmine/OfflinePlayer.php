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


use pocketmine\metadata\MetadataValue;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\Plugin;

class OfflinePlayer implements IPlayer
{

    private $name;
    private $server;
    private $namedtag;

    /**
     * @param Server $server
     * @param string $name
     */
    public function __construct(Server $server, $name)
    {
        $this->server = $server;
        $this->name = $name;
        if (file_exists($this->server->getDataPath() . "players/" . strtolower($this->getName()) . ".dat")) {
            $this->namedtag = $this->server->getOfflinePlayerData($this->name);
        } else {
            $this->namedtag = null;
        }
    }

    public function isOnline()
    {
        return $this->getPlayer() !== null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function isOp()
    {
        return $this->server->isOp(strtolower($this->getName()));
    }

    public function setOp($value)
    {
        if ($value === $this->isOp()) {
            return;
        }

        if ($value === true) {
            $this->server->addOp(strtolower($this->getName()));
        } else {
            $this->server->removeOp(strtolower($this->getName()));
        }
    }

    public function isBanned()
    {
        return $this->server->getNameBans()->isBanned(strtolower($this->getName()));
    }

    public function setBanned($value)
    {
        if ($value === true) {
            $this->server->getNameBans()->addBan($this->getName(), null, null, null);
        } else {
            $this->server->getNameBans()->remove($this->getName());
        }
    }

    public function isWhitelisted()
    {
        return $this->server->isWhitelisted(strtolower($this->getName()));
    }

    public function setWhitelisted($value)
    {
        if ($value === true) {
            $this->server->addWhitelist(strtolower($this->getName()));
        } else {
            $this->server->removeWhitelist(strtolower($this->getName()));
        }
    }

    public function getPlayer()
    {
        return $this->server->getPlayerExact($this->getName());
    }

    public function getFirstPlayed()
    {
        return $this->namedtag instanceof CompoundTag ? $this->namedtag["firstPlayed"] : null;
    }

    public function getLastPlayed()
    {
        return $this->namedtag instanceof CompoundTag ? $this->namedtag["lastPlayed"] : null;
    }

    public function hasPlayedBefore()
    {
        return $this->namedtag instanceof CompoundTag;
    }

    public function setMetadata($metadataKey, MetadataValue $metadataValue)
    {
        $this->server->getPlayerMetadata()->setMetadata($this, $metadataKey, $metadataValue);
    }

    public function getMetadata($metadataKey)
    {
        return $this->server->getPlayerMetadata()->getMetadata($this, $metadataKey);
    }

    public function hasMetadata($metadataKey)
    {
        return $this->server->getPlayerMetadata()->hasMetadata($this, $metadataKey);
    }

    public function removeMetadata($metadataKey, Plugin $plugin)
    {
        $this->server->getPlayerMetadata()->removeMetadata($this, $metadataKey, $plugin);
    }


}
