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

namespace pocketmine\wizard;


class InstallerLang
{
    public static $languages = [
        "eng" => "English",
        "chs" => "简体中文",
        "zho" => "繁體中文",
        "jpn" => "日本語",
        "rus" => "Русский"
    ];
    private $texts = [];
    private $lang;
    private $langfile;

    public function __construct($lang = "")
    {
        if (file_exists(\pocketmine\PATH . "src/pocketmine/lang/Installer/" . $lang . ".ini")) {
            $this->lang = $lang;
            $this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/" . $lang . ".ini";
        } else {
            $files = [];
            foreach (new \DirectoryIterator(\pocketmine\PATH . "src/pocketmine/lang/Installer/") as $file) {
                if ($file->getExtension() === "ini" and substr($file->getFilename(), 0, 2) === $lang) {
                    $files[$file->getFilename()] = $file->getSize();
                }
            }

            if (count($files) > 0) {
                arsort($files);
                reset($files);
                $l = key($files);
                $l = substr($l, 0, -4);
                $this->lang = isset(self::$languages[$l]) ? $l : $lang;
                $this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/" . $l . ".ini";
            } else {
                $this->lang = "en";
                $this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/eng.ini";
            }
        }

        $this->loadLang(\pocketmine\PATH . "src/pocketmine/lang/Installer/eng.ini", "eng");
        if ($this->lang !== "en") {
            $this->loadLang($this->langfile, $this->lang);
        }

    }

    public function getLang()
    {
        return ($this->lang);
    }

    public function loadLang($langfile, $lang = "en")
    {
        $this->texts[$lang] = [];
        $texts = explode("\n", str_replace(["\r", "\\/\\/"], ["", "//"], file_get_contents($langfile)));
        foreach ($texts as $line) {
            $line = trim($line);
            if ($line === "") {
                continue;
            }
            $line = explode("=", $line);
            $this->texts[$lang][trim(array_shift($line))] = trim(str_replace(["\\n", "\\N",], "\n", implode("=", $line)));
        }
    }

    public function get($name, $search = [], $replace = [])
    {
        if (!isset($this->texts[$this->lang][$name])) {
            if ($this->lang !== "en" and isset($this->texts["en"][$name])) {
                return $this->texts["en"][$name];
            } else {
                return $name;
            }
        } elseif (count($search) > 0) {
            return str_replace($search, $replace, $this->texts[$this->lang][$name]);
        } else {
            return $this->texts[$this->lang][$name];
        }
    }

    public function __get($name)
    {
        return $this->get($name);
    }

}
