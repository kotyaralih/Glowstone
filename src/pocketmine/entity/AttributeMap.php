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

namespace pocketmine\entity;

class AttributeMap implements \ArrayAccess
{
    /** @var Attribute[] */
    private $attributes = [];

    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[$attribute->getId()] = $attribute;
    }

    /**
     * @param int $id
     *
     * @return Attribute|null
     */
    public function getAttribute(int $id)
    {
        return $this->attributes[$id] ?? null;
    }

    /**
     * @return Attribute[]
     */
    public function needSend(): array
    {
        return array_filter($this->attributes, function (Attribute $attribute) {
            return $attribute->isSyncable() and $attribute->isDesynchronized();
        });
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset]->getValue();
    }

    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset]->setValue($value);
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException("Could not unset an attribute from an attribute map");
    }
}
