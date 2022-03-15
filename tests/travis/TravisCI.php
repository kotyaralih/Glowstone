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

$server = proc_open(PHP_BINARY . " src/pocketmine/PocketMine.php --no-wizard --disable-readline", [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
], $pipes);

fwrite($pipes[0], "version\nms\nstop\n\n");

while (!(feof($pipes[1]))) {
    $con = fgets($pipes[1]);

    echo $con;
    if (strpos($con, "stopped") > 0) {
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $ret = proc_close($server);
        break;
    }
}
if (!(isset($ret))) {
    $ret = proc_close($server);
}
echo "\n\nReturn value: ". $ret ."\n";

if (count(glob("plugins/Glowstone/Glowstone*.phar")) === 0) {
    echo "No Glowstone phar created!\n";
    exit(1);
} else {
    exit(0);
}