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

/**
 * Plugin related classes
 */

namespace pocketmine\plugin;

use pocketmine\command\CommandExecutor;


/**
 * It is recommended to use PluginBase for the actual plugin
 *
 */
interface Plugin extends CommandExecutor
{

    /**
     * Called when the plugin is loaded, before calling onEnable()
     */
    public function onLoad();

    /**
     * Called when the plugin is enabled
     */
    public function onEnable();

    public function isEnabled();

    /**
     * Called when the plugin is disabled
     * Use this to free open things and finish actions
     */
    public function onDisable();

    public function isDisabled();

    /**
     * Gets the plugin's data folder to save files and configuration
     */
    public function getDataFolder();

    /**
     * @return PluginDescription
     */
    public function getDescription();

    /**
     * Gets an embedded resource in the plugin file.
     *
     * @param string $filename
     */
    public function getResource($filename);

    /**
     * Saves an embedded resource to its relative location in the data folder
     *
     * @param string $filename
     * @param bool $replace
     */
    public function saveResource($filename, $replace = false);

    /**
     * Returns all the resources incrusted in the plugin
     */
    public function getResources();

    /**
     * @return \pocketmine\utils\Config
     */
    public function getConfig();

    public function saveConfig();

    public function saveDefaultConfig();

    public function reloadConfig();

    /**
     * @return \pocketmine\Server
     */
    public function getServer();

    public function getName();

    /**
     * @return PluginLogger
     */
    public function getLogger();

    /**
     * @return PluginLoader
     */
    public function getPluginLoader();

}