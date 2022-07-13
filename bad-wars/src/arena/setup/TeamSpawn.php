<?php

declare(strict_types=1);

namespace BedWars\arena\setup;

use BedWars\arena\Converter;
use BedWars\BedWars;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class TeamSpawn
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function setTeamSpawn(Player $sender, string $team): void
    {
        if (file_exists($this->plugin->getDataFolder() . "Arena.json")) {
            $pos = $sender->getPosition()->asVector3();

            $arena = new Config($this->plugin->getDataFolder() . "ArenaData.json", Config::JSON);

            $teamColor = new Converter();
            $teamC = $teamColor->convertTeamToColor($team);

            $arena->set("team.$teamC.spawn", $pos);
            $arena->save();

            $sender->sendMessage("§fBed§cWars §8» §aDu hast den Spawn von Team " . $team . " gesetzt!");
        } else {
            $sender->sendMessage("§cBed§fWars §8» §cError");
        }
    }
}