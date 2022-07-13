<?php

declare(strict_types=1);

namespace BedWars\setup;

use BedWars\Game;
use pocketmine\block\VanillaBlocks;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class LobbySetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function setLobby(Player $sender, $worldName): void
    {
        if (file_exists($this->plugin->getDataFolder() . "ServerData.json")) {
            $serverconfig = new Config($this->plugin->getDataFolder() . "ServerData.json", Config::JSON);
            $serverconfig->set("lobby", $worldName);
            $serverconfig->save();

            $sender->sendMessage("§fBed§cWars §8» §7Du hast die Wartelobby gesetzt!");
        } else {
            $sender->sendMessage("§fBed§cWars §8» §7Du musst als erstes den BedWars Server erstellen!");
        }
    }
}