<?php

namespace pocketmine\command\defaults;

use Phar;
use PharFileInfo;
use pocketmine\command\CommandSender;
use pocketmine\plugin\FolderPluginLoader;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class MakePluginCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Creates a Phar plugin from a unarchived",
            "/makeplugin <pluginName> (nogz)",
            ["mp"]
        );
        $this->setPermission("pocketmine.command.makeplugin");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) === 0) {
            $sender->sendMessage(TextFormat::RED . "Usage: " . $this->usageMessage);
            return true;
        }

        $pluginName = trim(implode(" ", $args));
        if ($pluginName === "" or !(($plugin = Server::getInstance()->getPluginManager()->getPlugin($pluginName)) instanceof Plugin)) {
            $sender->sendMessage(TextFormat::RED . "Invalid plugin name, check the name case.");
            return true;
        }
        $description = $plugin->getDescription();

        if (!($plugin->getPluginLoader() instanceof FolderPluginLoader)) {
            $sender->sendMessage(TextFormat::RED . "Plugin " . $description->getName() . " is not in folder structure.");
            return true;
        }

        $pharPath = Server::getInstance()->getPluginPath() . DIRECTORY_SEPARATOR . "Glowstone" . DIRECTORY_SEPARATOR . $description->getName() . "_v" . $description->getVersion() . ".phar";
        if (file_exists($pharPath)) {
            $sender->sendMessage("Phar plugin already exists, overwriting...");
            @unlink($pharPath);
        }
        $phar = new Phar($pharPath);
        $phar->setMetadata([
            "name" => $description->getName(),
            "version" => $description->getVersion(),
            "main" => $description->getMain(),
            "api" => $description->getCompatibleApis(),
            "depend" => $description->getDepend(),
            "description" => $description->getDescription(),
            "authors" => $description->getAuthors(),
            "website" => $description->getWebsite(),
            "creator" => "Glowstone MakePlugin Command",
            "creationDate" => time()
        ]);
        if ($description->getName() === "DevTools") {
            $phar->setStub('<?php require("phar://". __FILE__ ."/src/DevTools/ConsoleScript.php"); __HALT_COMPILER();');
        } else {
            $phar->setStub('<?php echo "PocketMine-MP/Glowstone plugin ' . $description->getName() . ' v' . $description->getVersion() . '\nThis file has been generated using Glowstone by Lunarelly at ' . date("r") . '\n----------------\n";if(extension_loaded("phar")){$phar = new \Phar(__FILE__);foreach($phar->getMetadata() as $key => $value){echo ucfirst($key).": ".(is_array($value) ? implode(", ", $value):$value)."\n";}} __HALT_COMPILER();');
        }
        $phar->setSignatureAlgorithm(Phar::SHA1);
        $reflection = new ReflectionClass("pocketmine\\plugin\\PluginBase");
        $file = $reflection->getProperty("file");
        $file->setAccessible(true);
        $filePath = rtrim(str_replace("\\", "/", $file->getValue($plugin)), "/") . "/";
        $phar->startBuffering();
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($filePath)) as $file) {
            $path = ltrim(str_replace(["\\", $filePath], ["/", ""], $file), "/");
            if ($path[0] === "." or strpos($path, "/.") !== false) {
                continue;
            }
            $phar->addFile($file, $path);
            $sender->sendMessage("[Glowstone] Adding $path");
        }

        foreach ($phar as $file => $finfo) {
            /** @var PharFileInfo $finfo */
            if ($finfo->getSize() > (1024 * 512)) {
                $finfo->compress(Phar::GZ);
            }
        }
        if (!isset($args[1]) or (isset($args[1]) and $args[1] != "nogz")) {
            $phar->compressFiles(Phar::GZ);
        }
        $phar->stopBuffering();
        $sender->sendMessage("Phar plugin " . $description->getName() . " v" . $description->getVersion() . " has been created on " . $pharPath);
        return true;
    }
}
