<?php

declare(strict_types=1);

namespace BedWars\setup;

use BedWars\arena\MapReset;
use BedWars\Game;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class ArenaSetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function createArena(Player $sender, string $arenaName, string $worldName): void
    {
        if (file_exists($this->plugin->getDataFolder() . "ServerData.json")) {
            mkdir($this->plugin->getDataFolder() . $arenaName);

            $copyArena = new MapReset();
            $copyArena->copyDir($this->plugin->getServer()->getDataPath() . "worlds/" . $arenaName, $this->plugin->getDataFolder() . $arenaName . "/map");

            $arenaconfig = new Config($this->plugin->getDataFolder() . "/{$arenaName}/ArenaData.json", Config::JSON);
            $arenaconfig->set("world", $worldName);
            $arenaconfig->save();

            $sender->sendMessage("§fBed§cWars §8» §7Du hast die Arena {$arenaName} erstellt!");
        } else {
            $sender->sendMessage("§fBed§cWars §8» §7Du musst als erstes den BedWars Server erstellen!");
        }
    }
}