<?php

declare(strict_types=1);

namespace SkyWars\arena\setup;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use SkyWars\Game;

class CreateArena
{
    public function __construct(private Game $plugin)
    {
    }

    public function createArena(Player $sender, string $arenaName, string $worldName, string $teams, string $ppt): void
    {
        if (file_exists($this->plugin->getServer()->getDataPath() . "worlds/" . $worldName)) {
            @mkdir("/home/server/database/skywars/arena/{$arenaName}");
            $arena = new Config("/home/server/database/skywars/arena/{$arenaName}/Arena.json", Config::JSON);
            $arena->set("arena", $arenaName);
            $arena->set("world", $worldName);
            $arena->set("lobby", "");
            $arena->set("teams", $teams);
            $arena->set("ppt", $ppt);
            $arena->set("player", 0);
            $arena->save();

            $getarena = new Config($this->plugin->getDataFolder() . "GetArena.json", Config::JSON);
            $getarena->set("arena", $arenaName);
            $getarena->save();

            $sender->sendMessage("§bSkyWars §8» §7Du hast die Arena {$arenaName} erstellt!");
        } else {
            $sender->sendMessage("§bSkyWars §8» §7Die Welt {$worldName} gibt es nicht!");
        }
    }
}