<?php

declare(strict_types=1);

namespace BedWars;

use AssertionError;
use BedWars\apis\invmenu\InvMenuHandler;
use BedWars\arena\ConfigReset;
use BedWars\arena\setup\CreateArena;
use BedWars\arena\setup\Spawner;
use BedWars\arena\setup\TeamBed;
use BedWars\arena\setup\TeamSpawn;
use BedWars\arena\setup\Villager;
use BedWars\arena\setup\WaitingArea;
use BedWars\game\GameTask;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\world\World;

class BedWars extends PluginBase
{
    public function onEnable(): void
    {
        $level = $this->getServer()->getWorldManager()->getDefaultWorld()->getDisplayName();
        $this->getServer()->getWorldManager()->loadWorld($level);

        $villager = Villager::class;
        EntityFactory::getInstance()->register($villager, function (World $world, CompoundTag $nbt)
        use ($villager): Villager {
            return new $villager(EntityDataHelper::parseLocation($nbt, $world));
        }, ["§cShop"]);

        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        $config = new ConfigReset($this);
        $config->reload();

        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getScheduler()->scheduleRepeatingTask(new GameTask($this), 20);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "bedwars":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("bedwars.setup")) {
                        if (!isset($args[0])) {
                            $sender->sendMessage("§8»»» §fBed§cWars §8«««");
                            $sender->sendMessage("§7/bedwars create [arenaName] [worldName] [teams(2/4/8)] [player[1-8]");
                            $sender->sendMessage("§7/bedwars waitingarea [arenaName] [worldName]");
                            $sender->sendMessage("§7/bedwars spawn [team]");
                            $sender->sendMessage("§7/bedwars bed [team]");
                            $sender->sendMessage("§7/bedwars orespawner [team] [type=(brick, iron, gold]");
                            $sender->sendMessage("§7bedwars villager");
                            $sender->sendMessage("§8»»» §fBed§cWars §8«««");
                        } elseif ($args[0] === "create") {
                            if (isset($args[1]) and isset($args[2]) and isset($args[3]) and isset($args[4])) {
                                $arenaName = $args[1];
                                $worldName = $args[2];
                                $teams = $args[3];
                                $player = $args[4];

                                $arena = new CreateArena($this);
                                $arena->createArena($sender, $arenaName, $worldName, $teams, $player);
                            } else {
                                $sender->sendMessage("§7/bedwars create [arenaName] [worldName] [teams(2-8)] [player[1-8]");
                            }
                        } elseif ($args[0] === "waitingarea") {
                            if (isset($args[1]) and isset($args[2])) {
                                $arenaName = $args[1];
                                $worldName = $args[2];

                                $area = new WaitingArea($this);
                                $area->setWaitingArea($sender, $arenaName, $worldName);
                            } else {
                                $sender->sendMessage("§7/bedwars waitingarea [arenaName] [worldName]");
                            }
                        } elseif ($args[0] === "spawn") {
                            if (isset($args[1])) {
                                $team = $args[1];

                                $spawn = new TeamSpawn($this);
                                $spawn->setTeamSpawn($sender, $team);
                            } else {
                                $sender->sendMessage("§7/bedwars spawn [team]");
                            }
                        } elseif ($args[0] === "bed") {
                            if (isset($args[1])) {
                                $team = $args[1];

                                $bed = new TeamBed($this);
                                $bed->setTeamBed($sender, $team);
                            } else {
                                $sender->sendMessage("§7/bedwars bed [team]");
                            }
                        } elseif ($args[0] === "orespawner") {
                            if (isset($args[1]) and isset($args[2])) {
                                $team = $args[1];
                                $type = $args[2];

                                $spawner = new Spawner($this);
                                $spawner->setSpawner($sender, $team, $type);
                            } else {
                                $sender->sendMessage("§7/bedwars orespawner [team] [type=(brick, iron, gold]");
                            }
                        } elseif ($args[0] === "villager") {
                            $villager = new Villager($sender->getLocation());
                            $villager->spawnTo($sender);
                        }
                    }
                }
                return true;
            case "start":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("bedwars.start")) {
                        $config = new Config($this->getDataFolder() . "Arena.json", Config::JSON);
                        $status = $config->get("status");

                        if ($status === "lobby") $config->set("startTime", 6); $config->save();
                    }
                }
                return true;
            default:
                throw new AssertionError("");
        }
    }
}