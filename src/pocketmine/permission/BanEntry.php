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

namespace pocketmine\permission;

class BanEntry
{
    public static $format = "Y-m-d H:i:s O";

    private $name;
    /** @var \DateTime */
    private $creationDate = null;
    private $source = "Unknown";
    /** @var \DateTime */
    private $expirationDate = null;
    private $reason = "not stated";

    public function __construct($name)
    {
        $this->name = strtolower($name);
        $this->creationDate = new \DateTime();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreated()
    {
        return $this->creationDate;
    }

    public function setCreated(\DateTime $date)
    {
        $this->creationDate = $date;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getExpires()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $date
     */
    public function setExpires($date)
    {
        $this->expirationDate = $date;
    }

    public function hasExpired()
    {
        $now = new \DateTime();

        return $this->expirationDate === null ? false : $this->expirationDate < $now;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getString()
    {
        $str = "";
        $str .= $this->getName();
        $str .= "|";
        $str .= $this->getCreated()->format(self::$format);
        $str .= "|";
        $str .= $this->getSource();
        $str .= "|";
        $str .= $this->getExpires() === null ? "Forever" : $this->getExpires()->format(self::$format);
        $str .= "|";
        $str .= $this->getReason();

        return $str;
    }

    /**
     * @param string $str
     *
     * @return BanEntry
     */
    public static function fromString($str)
    {
        if (strlen($str) < 2) {
            return null;
        } else {
            $str = explode("|", trim($str));
            $entry = new BanEntry(trim(array_shift($str)));
            if (count($str) > 0) {
                $entry->setCreated(\DateTime::createFromFormat(self::$format, array_shift($str)));
                if (count($str) > 0) {
                    $entry->setSource(trim(array_shift($str)));
                    if (count($str) > 0) {
                        $expire = trim(array_shift($str));
                        if (strtolower($expire) !== "forever" and strlen($expire) > 0) {
                            $entry->setExpires(\DateTime::createFromFormat(self::$format, $expire));
                        }
                        if (count($str) > 0) {
                            $entry->setReason(trim(array_shift($str)));
                        }
                    }
                }
            }

            return $entry;
        }
    }
}