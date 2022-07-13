<?php

declare(strict_types=1);

namespace BedWars;

use AssertionError;
use BedWars\game\spawner\BrickSpawner;
use BedWars\setup\ArenaSetup;
use BedWars\setup\BedSetup;
use BedWars\setup\LobbySetup;
use BedWars\setup\ServerSetup;
use BedWars\setup\SpawnerSetup;
use BedWars\setup\SpawnSetup;
use BedWars\setup\SpawnVillager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Game extends PluginBase
{
    public function onEnable(): void
    {
        $serverconfig = new Config($this->getDataFolder() . "ServerData.json", Config::JSON);
        if ($serverconfig->exists("server")) $this->getServer()->getNetwork()->setName("§7BedWars-{$serverconfig->get("server")}");

        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getScheduler()->scheduleRepeatingTask(new BrickSpawner($this), 60);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "bedwars":
            case "bw":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("bedwars.setup")) {
                        if (!isset($args[0])) {
                            $sender->sendMessage("§8-=== §fBed§cWars §8===-");
                            $sender->sendMessage("§7/bw server [server] [teams] [ppt] \nSupported: 2x1, 2x4, 4x2, 4x4, 8x1");
                            $sender->sendMessage("§7/bw lobby [worldName]");
                            $sender->sendMessage("§7/bw create [arenaName] [worldName]");
                            $sender->sendMessage("§7/bw spawn [arenaName] [team]");
                            $sender->sendMessage("§7/bw bed [arenaName] [team]");
                            $sender->sendMessage("§7/bw villager");
                            $sender->sendMessage("§8-=== §fBed§cWars §8===-");
                        } elseif ($args[0] === "server") {
                            if (isset($args[1]) and isset($args[2]) and isset($args[3])) {
                                $server = $args[1];
                                $teams = $args[2];
                                $ppt = $args[3];

                                $serverSetup = new ServerSetup($this);
                                $serverSetup->setServer($sender, $server, $teams, $ppt);
                            } else {
                                $sender->sendMessage("§7/bw server [server] [teams] [ppt] \nSupported: 2x1, 2x4, 4x2, 4x4, 8x1");
                            }
                        } elseif ($args[0] === "lobby") {
                            if (isset($args[1])) {
                                $worldName = $args[1];

                                $lobbySetup = new LobbySetup($this);
                                $lobbySetup->setLobby($sender, $worldName);
                            } else {
                                $sender->sendMessage("§7/bw lobby [worldName]");
                            }
                        } elseif ($args[0] === "create") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $worldName = $args[2];

                                $arenaSetup = new ArenaSetup($this);
                                $arenaSetup->createArena($sender, $arenaName, $worldName);
                            } else {
                                $sender->sendMessage("§7/bw create [arenaName] [worldName]");
                            }
                        } elseif ($args[0] === "spawn") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $team = $args[2];

                                $spawnSetup = new SpawnSetup($this);
                                $spawnSetup->setSpawn($sender, $arenaName, $team);
                            } else {
                                $sender->sendMessage("§7/bw spawn [arenaName] [team]");
                            }
                        } elseif ($args[0] === "bed") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $team = $args[2];

                                $bedSetup = new BedSetup($this);
                                $bedSetup->setBed($sender, $arenaName, $team);
                            } else {
                                $sender->sendMessage("§7/bw bed [arenaName] [team]");
                            }
                        } elseif ($args[0] === "villager") {
                            $villager = new SpawnVillager($sender->getLocation());
                            $villager->spawnTo($sender);
                        }
                    }
                } else {
                    $sender->sendMessage("§fBed§cWars §8» §7Der Command kann nur ingame ausgeführt werden!");
                }
                return true;
            case "start":
            case "s":
                if ($sender->hasPermission("bedwars.start")) {

                }
                return true;
            default:
                throw new AssertionError("");
        }
    }
}