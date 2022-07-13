<?php

declare(strict_types=1);

namespace BedWars\setup;

use BedWars\Game;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class ServerSetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function setServer(Player $sender, string $server, string $teams, string $ppt): void
    {
        $serverconfig = new Config($this->plugin->getDataFolder() . "ServerData.json", Config::JSON);
        $serverconfig->set("server", $server);
        $serverconfig->set("teams", $teams);
        $serverconfig->set("ppt", $ppt);
        $serverconfig->save();

        $sender->sendMessage("§fBed§cWars §8» §7BedWars-{$server} wurde erstellt!");
    }
}