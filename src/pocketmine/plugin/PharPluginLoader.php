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

namespace pocketmine\plugin;

use pocketmine\event\plugin\PluginDisableEvent;
use pocketmine\event\plugin\PluginEnableEvent;
use pocketmine\Server;
use pocketmine\utils\PluginException;

/**
 * Handles different types of plugins
 */
class PharPluginLoader implements PluginLoader
{

    /** @var Server */
    private $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Loads the plugin contained in $file
     *
     * @param string $file
     *
     * @return Plugin
     *
     * @throws \Throwable
     */
    public function loadPlugin($file)
    {
        if (($description = $this->getPluginDescription($file)) instanceof PluginDescription) {
            $this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.plugin.load", [$description->getFullName()]));
            $dataFolder = dirname($file) . DIRECTORY_SEPARATOR . $description->getName();
            if (file_exists($dataFolder) and !is_dir($dataFolder)) {
                throw new \InvalidStateException("Projected dataFolder '" . $dataFolder . "' for " . $description->getName() . " exists and is not a directory");
            }
            $file = "phar://$file";
            $className = $description->getMain();
            $this->server->getLoader()->addPath("$file/src");

            if (class_exists($className, true)) {
                $plugin = new $className();
                $this->initPlugin($plugin, $description, $dataFolder, $file);

                return $plugin;
            } else {
                throw new PluginException("Couldn't load plugin " . $description->getName() . ": main class not found");
            }
        }

        return null;
    }

    /**
     * Gets the PluginDescription from the file
     *
     * @param string $file
     *
     * @return PluginDescription
     */
    public function getPluginDescription($file)
    {
        $phar = new \Phar($file);
        if (isset($phar["plugin.yml"])) {
            $pluginYml = $phar["plugin.yml"];
            if ($pluginYml instanceof \PharFileInfo) {
                return new PluginDescription($pluginYml->getContent());
            }
        }

        return null;
    }

    /**
     * Returns the filename patterns that this loader accepts
     *
     * @return array
     */
    public function getPluginFilters()
    {
        return "/\\.phar$/i";
    }

    /**
     * @param PluginBase $plugin
     * @param PluginDescription $description
     * @param string $dataFolder
     * @param string $file
     */
    private function initPlugin(PluginBase $plugin, PluginDescription $description, $dataFolder, $file)
    {
        $plugin->init($this, $this->server, $description, $dataFolder, $file);
        $plugin->onLoad();
    }

    /**
     * @param Plugin $plugin
     */
    public function enablePlugin(Plugin $plugin)
    {
        if ($plugin instanceof PluginBase and !$plugin->isEnabled()) {
            $this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.plugin.enable", [$plugin->getDescription()->getFullName()]));

            $plugin->setEnabled(true);

            $this->server->getPluginManager()->callEvent(new PluginEnableEvent($plugin));
        }
    }

    /**
     * @param Plugin $plugin
     */
    public function disablePlugin(Plugin $plugin)
    {
        if ($plugin instanceof PluginBase and $plugin->isEnabled()) {
            $this->server->getLogger()->info($this->server->getLanguage()->translateString("pocketmine.plugin.disable", [$plugin->getDescription()->getFullName()]));

            $this->server->getPluginManager()->callEvent(new PluginDisableEvent($plugin));

            $plugin->setEnabled(false);
        }
    }
}