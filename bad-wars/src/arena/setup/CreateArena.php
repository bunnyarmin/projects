<?php

declare(strict_types=1);

namespace BedWars\arena\setup;

use BedWars\arena\MapReset;
use BedWars\BedWars;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class CreateArena
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function createArena(Player $sender, string $arenaName, string $worldName, string $teams, string $player): void
    {
        if (is_dir($this->plugin->getServer()->getDataPath() . "worlds/" . $worldName)) {
            $map = new MapReset();
            $map->copyDir($this->plugin->getServer()->getDataPath() . "worlds/" . $worldName, $this->plugin->getDataFolder() . $worldName);

            $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
            $arena->set("name", $arenaName);
            $arena->set("teams", (int)$teams);
            $arena->set("player", (int)$player);
            $arena->save();

            $this->plugin->getServer()->getWorldManager()->loadWorld($worldName);
            $level = $this->plugin->getServer()->getWorldManager()->getWorldByName($worldName);
            $spawn = $level->getSpawnLocation()->asPosition();
            $sender->teleport($spawn);

            $sender->sendMessage("§fBed§cWars §8» §aDu hast die Arena " . $arenaName . " erstellt!");
            $sender->sendMessage("§fBed§cWars §8» §7Setze nun die Welt für die Wartelobby!");
        } else {
            $sender->sendMessage("§fBed§cWars §8» §cDie Welt " . $worldName . " gibt es nicht!");
        }
    }
}