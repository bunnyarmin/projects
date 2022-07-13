<?php

declare(strict_types=1);

namespace LobbySystem\tasks;

use LobbySystem\Lobby;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class GadgetTask extends Task
{
    public function __construct(private Lobby $plugin)
    {
    }

    public function onRun(): void
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer){
            $pdata = new Config($this->plugin->getDataFolder() . $onlinePlayer->getName() . ".json", Config::JSON);
            if ()
        }
    }
}