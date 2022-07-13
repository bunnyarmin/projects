<?php

declare(strict_types=1);

namespace SkyWars\arena\setup;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use SkyWars\Game;

class LobbySetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function setLobby(Player $sender, string $arenaName, string $worldName): void
    {
        if (file_exists($this->plugin->getServer()->getDataPath() . "worlds/" . $worldName)) {
            $arena = new Config("/home/server/database/skywars/arena/{$arenaName}/Arena.json", Config::JSON);
            $arena->set("lobby", $worldName);
            $arena->save();

            $sender->sendMessage("§bSkyWars §8» §7Du hast die Wartelobby erstellt!");
        } else {
            $sender->sendMessage("§bSkyWars §8» §7Die Welt {$worldName} gibt es nicht!");
        }
    }
}