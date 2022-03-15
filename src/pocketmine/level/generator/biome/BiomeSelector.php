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

namespace pocketmine\level\generator\biome;

use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;
use SplFixedArray;

class BiomeSelector
{

    /** @var Biome */
    private $fallback;

    /** @var Simplex */
    private $temperature;
    /** @var Simplex */
    private $rainfall;

    /** @var Biome[] */
    private $biomes = [];

    private $map = [];

    private $lookup;

    public function __construct(Random $random, callable $lookup, Biome $fallback)
    {
        $this->fallback = $fallback;
        $this->lookup = $lookup;
        $this->temperature = new Simplex($random, 2, 1 / 16, 1 / 512);
        $this->rainfall = new Simplex($random, 2, 1 / 16, 1 / 512);
    }

    public function recalculate()
    {
        $this->map = new SplFixedArray(64 * 64);

        for ($i = 0; $i < 64; ++$i) {
            for ($j = 0; $j < 64; ++$j) {
                $this->map[$i + ($j << 6)] = call_user_func($this->lookup, $i / 63, $j / 63);
            }
        }
    }

    public function addBiome(Biome $biome)
    {
        $this->biomes[$biome->getId()] = $biome;
    }

    public function getTemperature($x, $z)
    {
        return ($this->temperature->noise2D($x, $z, true) + 1) / 2;
    }

    public function getRainfall($x, $z)
    {
        return ($this->rainfall->noise2D($x, $z, true) + 1) / 2;
    }

    /**
     * @param $x
     * @param $z
     *
     * @return Biome
     */
    public function pickBiome($x, $z)
    {
        $temperature = (int)($this->getTemperature($x, $z) * 63);
        $rainfall = (int)($this->getRainfall($x, $z) * 63);

        $biomeId = $this->map[$temperature + ($rainfall << 6)];
        return isset($this->biomes[$biomeId]) ? $this->biomes[$biomeId] : $this->fallback;
    }
}