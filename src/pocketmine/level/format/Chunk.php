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

interface Chunk extends FullChunk
{
    const SECTION_COUNT = 8;

    /**
     * Tests whether a section (mini-chunk) is empty
     *
     * @param $fY 0-7, (Y / 16)
     *
     * @return bool
     */
    public function isSectionEmpty($fY);

    /**
     * @param int $fY 0-7
     *
     * @return ChunkSection
     */
    public function getSection($fY);

    /**
     * @param int $fY 0-7
     * @param ChunkSection $section
     *
     * @return boolean
     */
    public function setSection($fY, ChunkSection $section);

    /**
     * @return ChunkSection[]
     */
    public function getSections();

}