<?php

declare(strict_types=1);

namespace ServerEngine;

use AssertionError;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use ServerEngine\ban\BanForm;
use ServerEngine\ban\UnbanForm;
use ServerEngine\coins\Coins;
use ServerEngine\group\GroupForm;
use ServerEngine\group\Nick;
use ServerEngine\more\PDataForm;
use ServerEngine\mute\MuteForm;
use ServerEngine\mute\UnmuteForm;

class Engine extends PluginBase
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "group":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.group")) {
                        $groupFile = new GroupForm($this);
                        $groupForm = $groupFile->createGroupForm();
                        $sender->sendForm($groupForm);
                    }
                }
                return true;
            case "nick":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.nick")) {
                        $nickFile = new Nick();
                        $nickFile->nick($sender);
                    }
                }
                return true;
            case "coins":
                if ($sender instanceof Player) {
                    $coinFile = new Coins();
                    $coins = $coinFile->getCoins($sender);
                    $sender->sendMessage("§6BunnyGames §8» §7Du hast §a" . $coins . " §7Coins!");
                }
                return true;
            case "eban":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.eban")) {
                        $banFile = new BanForm($this);
                        $banForm = $banFile->createBanForm();
                        $sender->sendForm($banForm);
                    }
                }
                return true;
            case "eunban":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.eunban")) {
                        $unbanFile = new UnbanForm();
                        $unbanForm = $unbanFile->createUnbanForm();
                        $sender->sendForm($unbanForm);
                    }
                }
                return true;
            case "emute":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.emute")) {
                        $muteFile = new MuteForm($this);
                        $muteForm = $muteFile->createMuteForm();
                        $sender->sendForm($muteForm);
                    }
                }
                return true;
            case "eunmute":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.eunmute")) {
                        $unmuteFile = new UnmuteForm($this);
                        $unmuteForm = $unmuteFile->createUnmuteForm();
                        $sender->sendForm($unmuteForm);
                    }
                }
                return true;
            case "estatus":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.estatus")) {
                        $count = count(glob("/home/server/database/player/*"));
                        $sender->sendMessage("§6BunnyGames §8» §7Es wurden insgesamt §a" . $count . " §7Spieler angemeldet!");
                    }
                }
                return true;
            case "playerdata":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("serverengine.pdata"))
                        if (isset($args[0])) {
                            if (file_exists("/home/server/database/player/" . $args[0] . ".json")) {
                                $pdataFile = new PDataForm();
                                $pdataForm = $pdataFile->createPlayerDataForm($args[0]);
                                $sender->sendForm($pdataForm);
                            } else {
                                $sender->sendMessage("§cDer Spieler existiert nicht!");
                            }
                        } else {
                            $sender->sendMessage("§c/playerdata (spielername)");
                        }
                }
                return true;
            default:
                throw new AssertionError("This line will never be executed");
        }
    }
}