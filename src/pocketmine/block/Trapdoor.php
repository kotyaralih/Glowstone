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

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\sound\DoorSound;
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

class Trapdoor extends Transparent
{

    protected $id = self::TRAPDOOR;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName(): string
    {
        return "Wooden Trapdoor";
    }

    public function getHardness()
    {
        return 3;
    }

    public function getResistance()
    {
        return 15;
    }

    public function canBeActivated(): bool
    {
        return true;
    }

    protected function recalculateBoundingBox()
    {

        $damage = $this->getDamage();

        $f = 0.1875;

        if (($damage & 0x08) > 0) {
            $bb = new AxisAlignedBB(
                $this->x,
                $this->y + 1 - $f,
                $this->z,
                $this->x + 1,
                $this->y + 1,
                $this->z + 1
            );
        } else {
            $bb = new AxisAlignedBB(
                $this->x,
                $this->y,
                $this->z,
                $this->x + 1,
                $this->y + $f,
                $this->z + 1
            );
        }

        if (($damage & 0x04) > 0) {
            if (($damage & 0x03) === 0) {
                $bb->setBounds(
                    $this->x,
                    $this->y,
                    $this->z + 1 - $f,
                    $this->x + 1,
                    $this->y + 1,
                    $this->z + 1
                );
            } elseif (($damage & 0x03) === 1) {
                $bb->setBounds(
                    $this->x,
                    $this->y,
                    $this->z,
                    $this->x + 1,
                    $this->y + 1,
                    $this->z + $f
                );
            }
            if (($damage & 0x03) === 2) {
                $bb->setBounds(
                    $this->x + 1 - $f,
                    $this->y,
                    $this->z,
                    $this->x + 1,
                    $this->y + 1,
                    $this->z + 1
                );
            }
            if (($damage & 0x03) === 3) {
                $bb->setBounds(
                    $this->x,
                    $this->y,
                    $this->z,
                    $this->x + $f,
                    $this->y + 1,
                    $this->z + 1
                );
            }
        }

        return $bb;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        if (($target->isTransparent() === false or $target->getId() === self::SLAB) and $face !== 0 and $face !== 1) {
            switch ($face) {
                case 2:
                    $this->meta |= 0b00000011;
                    break;
                case 3:
                    $this->meta |= 0b00000010;
                    break;
                case 4:
                    $this->meta |= 0b00000001;
                    break;
                case 5:
                    break;
            }
            if ($fy > 0.5) {
                $this->meta |= 0b00000100;
            }
            $this->getLevel()->setBlock($block, $this, true, true);
            return true;
        }
        return false;
    }

    public function getDrops(Item $item): array
    {
        return [
            [$this->id, 0, 1],
        ];
    }

    public function isOpened()
    {
        return (($this->meta & 0b00001000) === 0);
    }

    public function onActivate(Item $item, Player $player = \null)
    {
        $this->meta ^= 0b00001000;
        $this->getLevel()->setBlock($this, $this, true);
        $this->level->addSound(new DoorSound($this));
        return true;
    }

    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }
}
