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

namespace pocketmine\utils;


/**
 * @deprecated
 */
abstract class TextWrapper
{

    private static $characterWidths = [
        4, 2, 5, 6, 6, 6, 6, 3, 5, 5, 5, 6, 2, 6, 2, 6,
        6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 2, 2, 5, 6, 5, 6,
        7, 6, 6, 6, 6, 6, 6, 6, 6, 4, 6, 6, 6, 6, 6, 6,
        6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 4, 6, 4, 6, 6,
        6, 6, 6, 6, 6, 5, 6, 6, 2, 6, 5, 3, 6, 6, 6, 6,
        6, 6, 6, 4, 6, 6, 6, 6, 6, 6, 5, 2, 5, 7
    ];

    const CHAT_WINDOW_WIDTH = 240;
    const CHAT_STRING_LENGTH = 119;

    private static $allowedChars = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_abcdefghijklmnopqrstuvwxyz{|}~";

    private static $allowedCharsArray = [];

    public static function init()
    {
        self::$allowedCharsArray = [];
        $len = strlen(self::$allowedChars);
        for ($i = 0; $i < $len; ++$i) {
            self::$allowedCharsArray[self::$allowedChars[$i]] = self::$characterWidths[$i];
        }
    }

    /**
     * @param $text
     *
     * @return string
     * @deprecated
     *
     */
    public static function wrap($text)
    {
        $result = "";
        $len = strlen($text);
        $lineWidth = 0;
        $lineLength = 0;

        for ($i = 0; $i < $len; ++$i) {
            $char = $text[$i];

            if ($char === "\n") {
                $lineLength = 0;
                $lineWidth = 0;
            } elseif (isset(self::$allowedCharsArray[$char])) {
                $width = self::$allowedCharsArray[$char];

                if ($lineLength + 1 > self::CHAT_STRING_LENGTH or $lineWidth + $width > self::CHAT_WINDOW_WIDTH) {
                    $result .= "\n";
                    $lineLength = 0;
                    $lineWidth = 0;
                }

                ++$lineLength;
                $lineWidth += $width;
            } else {
                return $text;
            }

            $result .= $char;
        }

        return $result;
    }
}