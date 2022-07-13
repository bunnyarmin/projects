<?php

declare(strict_types=1);

namespace BedWars\game;

use BedWars\BedWars;
use BedWars\game\ore\BrickSpawner;
use BedWars\game\player\Warper;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use pocketmine\world\sound\PopSound;
use pocketmine\world\sound\Sound;

class GameTask extends Task
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function onRun(): void
    {
        $config = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

        $status = $config->get("status");
        $gamePlayer = $config->get("gamePlayer");
        $playerTeam = $config->get("playerTeam");
        $startTime = $config->get("startTime");
        $endTime = $config->get("endTime");

        if ($status === "lobby"){
            if ($gamePlayer < 2){
                foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer){
                    $onlinePlayer->sendActionBarMessage("§fBed§cWars §8» §7Warte auf weitere Spieler!");
                }
            }else{
                $startTime--;
                $config->set("startTime", $startTime);
                $config->save();

                if ($startTime === 60 or
                    $startTime === 50 or
                    $startTime === 40 or
                    $startTime === 30 or
                    $startTime === 20 or
                    $startTime === 10){
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer){
                        $onlinePlayer->sendMessage("§fBed§cWars §8» §7Die Runde startet in " . $startTime . " Sekunden!");
                        $onlinePlayer->broadcastSound(new PopSound());
                    }
                }elseif ($startTime === 5 or $startTime === 4 or  $startTime === 3 or $startTime === 2 or $startTime === 1){
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer){
                        $onlinePlayer->sendTitle(" ", "§c".$startTime);
                        $onlinePlayer->broadcastSound(new PopSound());

                        $tp = new Warper($this->plugin);
                        $tp->setTeamForPlayer($onlinePlayer);
                    }
                }elseif ($startTime === 0){
                    $nulltime = $startTime;
                    $config->set("startTime", $nulltime);
                    $config->set("status", "ingame");
                    $config->save();

                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer){
                        $tp = new Warper($this->plugin);
                        $tp->teleportToSpawn($onlinePlayer);
                    }
                }
            }
        }elseif ($status === "ingame"){
            if ($config->get("gamePlayer") === 1){
                $config->set("status", "end");
                $config->save();
            }
        }elseif ($status === "end"){
            $endTime--;
            $config->set("endTime", $endTime);
            $config->save();
            if ($config->get("endtime") === 15){
                //teleport wartelobby#
                //messages gg winner bla bla
            }
        }
    }
}