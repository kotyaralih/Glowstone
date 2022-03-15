<?php

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;

class BanCidCommand extends VanillaCommand
{

    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.bancid.description",
            "/ban-cid <client id>"
        );
        $this->setPermission("pocketmine.command.bancid");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0) {
            $sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

            return false;
        }

        $cid = array_shift($args);
        $reason = implode(" ", $args);

        $sender->getServer()->getCIDBans()->addBan($cid, $reason, null, $sender->getName());

        $player = null;

        foreach ($sender->getServer()->getOnlinePlayers() as $p) {
            if ($p->getClientId() == $cid) {
                $p->kick($reason !== "" ? "Banned by admin. Reason:" . $reason : "Banned by admin.");
                $player = $p;
                break;
            }
        }

        Command::broadcastCommandMessage($sender, new TranslationContainer("Banned client id ", [$player !== null ? $player->getName() : $cid]));

        return true;
    }
}
