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

namespace pocketmine\event\entity;

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;

class EntityDamageByEntityEvent extends EntityDamageEvent
{

    /** @var Entity */
    private $damager;
    /** @var float */
    private $knockBack;

    /**
     * @param Entity $damager
     * @param Entity $entity
     * @param int $cause
     * @param int|int[] $damage
     * @param float $knockBack
     */
    public function __construct(Entity $damager, Entity $entity, $cause, $damage, $knockBack = 0.4)
    {
        $this->damager = $damager;
        $this->knockBack = $knockBack;
        parent::__construct($entity, $cause, $damage);
        $this->addAttackerModifiers($damager);
    }

    protected function addAttackerModifiers(Entity $damager)
    {
        if ($damager->hasEffect(Effect::STRENGTH)) {
            $this->setDamage(1 + 0.3 * ($damager->getEffect(Effect::STRENGTH)->getAmplifier() + 1), self::MODIFIER_STRENGTH);
        }

        if ($damager->hasEffect(Effect::WEAKNESS)) {
            $eff_level = 1 - 0.2 * ($damager->getEffect(Effect::WEAKNESS)->getAmplifier() + 1);
            if ($eff_level < 0) {
                $eff_level = 0;
            }
            $this->setDamage($eff_level, self::MODIFIER_WEAKNESS);
        }
    }

    /**
     * @return Entity
     */
    public function getDamager()
    {
        return $this->damager;
    }

    /**
     * @return float
     */
    public function getKnockBack()
    {
        return $this->knockBack;
    }

    /**
     * @param float $knockBack
     */
    public function setKnockBack($knockBack)
    {
        $this->knockBack = $knockBack;
    }
}
