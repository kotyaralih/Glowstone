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

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\level\format\FullChunk;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\Player;

class Boat extends Vehicle
{
    const NETWORK_ID = 90;

    const DATA_WOOD_ID = 20;

    public $height = 0.7;
    public $width = 1.6;

    public $gravity = 0.5;
    public $drag = 0.1;

    public function __construct(FullChunk $chunk, CompoundTag $nbt)
    {
        if (!isset($nbt->WoodID)) {
            $nbt->WoodID = new IntTag("WoodID", 0);
        }
        parent::__construct($chunk, $nbt);
        $this->setDataProperty(self::DATA_WOOD_ID, self::DATA_TYPE_BYTE, $this->getWoodID());
    }

    public function getWoodID(): int
    {
        return (int)$this->namedtag["WoodID"];
    }

    public function spawnTo(Player $player)
    {
        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = Boat::NETWORK_ID;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->speedX = 0;
        $pk->speedY = 0;
        $pk->speedZ = 0;
        $pk->yaw = 0;
        $pk->pitch = 0;
        $pk->metadata = $this->dataProperties;
        $player->dataPacket($pk);

        parent::spawnTo($player);
    }

    public function attack($damage, EntityDamageEvent $source)
    {
        parent::attack($damage, $source);

        if (!$source->isCancelled()) {
            $pk = new EntityEventPacket();
            $pk->eid = $this->id;
            $pk->event = EntityEventPacket::HURT_ANIMATION;
            foreach ($this->getLevel()->getPlayers() as $player) {
                $player->dataPacket($pk);
            }
        }
    }

    public function onUpdate($currentTick)
    {
        if ($this->closed) {
            return false;
        }
        $tickDiff = $currentTick - $this->lastUpdate;
        if ($tickDiff <= 0 and !$this->justCreated) {
            return true;
        }

        $this->lastUpdate = $currentTick;

        $this->timings->startTiming();

        $hasUpdate = $this->entityBaseTick($tickDiff);

        if (!$this->level->getBlock(new Vector3($this->x, $this->y, $this->z))->getBoundingBox() == null or $this->isInsideOfWater()) {
            $this->motionY = 0.1;
        } else {
            $this->motionY = -0.08;
        }

        $this->move($this->motionX, $this->motionY, $this->motionZ);
        $this->updateMovement();

        if ($this->linkedEntity == null or $this->linkedType = 0) {
            if ($this->age > 1500) {
                $this->close();
                $hasUpdate = true;
                //$this->scheduleUpdate();

                $this->age = 0;
            }
            $this->age++;
        } else $this->age = 0;

        $this->timings->stopTiming();


        return $hasUpdate or !$this->onGround or abs($this->motionX) > 0.00001 or abs($this->motionY) > 0.00001 or abs($this->motionZ) > 0.00001;
    }


    public function getDrops()
    {
        return [
            ItemItem::get(ItemItem::BOAT, 0, 1)
        ];
    }

    public function getSaveId()
    {
        $class = new \ReflectionClass(static::class);
        return $class->getShortName();
    }
}
