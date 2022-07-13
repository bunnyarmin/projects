<?php

declare(strict_types=1);

namespace LobbySystem;

use pocketmine\plugin\PluginBase;

class Lobby extends PluginBase
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
    }
}