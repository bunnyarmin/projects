<?php

declare(strict_types=1);

namespace BedWars\arena\setup;

use BedWars\arena\Converter;
use BedWars\BedWars;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Spawner
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function setSpawner(Player $sender, string $team, string $type): void
    {
        if (file_exists($this->plugin->getDataFolder() . "Arena.json")) {
            $pos = $sender->getPosition()->asVector3();

            $arena = new Config($this->plugin->getDataFolder() . "ArenaData.json", Config::JSON);

            $teamColor = new Converter();
            $teamC = $teamColor->convertTeamToColor($team);

            switch ($type) {
                case "brick":
                    $arena->set("brick.spawner.$teamC", $pos);
                    $arena->save();
                    break;
                case "iron":
                    $arena->set("iron.spawner.$teamC", $pos);
                    $arena->save();
                    break;
                case "gold":
                    $arena->set("gold.spawner.$teamC", $pos);
                    $arena->save();
                    break;
            }

            $sender->sendMessage("§fBed§cWars §8» §aDu hast den " . $type . " Spawner von Team " . $team . " gesetzt!");
        } else {
            $sender->sendMessage("§cBed§fWars §8» §cError");
        }
    }
}