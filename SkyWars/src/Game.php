<?php

declare(strict_types=1);

namespace SkyWars;

use AssertionError;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use SkyWars\arena\setup\CreateArena;
use SkyWars\arena\setup\LobbySetup;
use SkyWars\arena\setup\SpawnSetup;

class Game extends PluginBase
{
    public function onEnable(): void
    {
        $arena = new Config("/home/server/database/skywars/arena/{$arenaName}/Arena.json", Config::JSON);

        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "sw":
            case "skywars":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("skywars.setup")) {
                        if (!isset($args[0])) {
                            $sender->sendMessage("§8-=== §bSkyWars §8===-");
                            $sender->sendMessage("§7/sw create [arenaName] [worldName] [teams] [ppt]");
                            $sender->sendMessage("§7/sw lobby [arenaName] [worldName]");
                            $sender->sendMessage("§7/sw spawn [arenaName] [team]");
                            $sender->sendMessage("§8-=== §bSkyWars §8===-");
                        } elseif ($args[0] === "create") {
                            if (isset($args[1]) and isset($args[2]) and isset($args[3]) and isset($args[4])) {
                                $arenaName = $args[1];
                                $worldName = $args[2];
                                $teams = $args[3];
                                $ppt = $args[4];

                                $arena = new CreateArena($this);
                                $arena->createArena($sender, $arenaName, $worldName, $teams, $ppt);
                            } else {
                                $sender->sendMessage("§7/sw create [arenaName] [teams] [ppt]");
                            }
                        } elseif ($args[0] === "lobby") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $worldName = $args[2];

                                $lobby = new LobbySetup($this);
                                $lobby->setLobby($sender, $arenaName, $worldName);
                            } else {
                                $sender->sendMessage("§7/sw lobby [arenaName] [worldName]");
                            }
                        } elseif ($args[0] === "spawn") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $team = $args[2];

                                $spawn = new SpawnSetup($this);
                                $spawn->setSpawn($sender, $arenaName, $team);
                            } else {
                                $sender->sendMessage("§7/sw spawn [arenaName] [team]");
                            }
                        }
                    }
                }
                return true;
            case "start":
            case "s":
                return true;
            default:
                throw new AssertionError("");
        }
    }
}