<?php

declare(strict_types=1);

namespace BedWars\arena;

use BedWars\BedWars;
use pocketmine\utils\Config;

class ConfigReset
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function reload(): void
    {
        if (file_exists($this->plugin->getDataFolder() . "Arena.json")){
            $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

            $arenaName = $arena->get("name");
            $waitingArea = $arena->get("waitingarea");
            $teams = $arena->get("teams");
            $player = $arena->get("player");

            $arena->remove($arenaName);
            $arena->remove($waitingArea);
            $arena->remove($teams);
            $arena->remove($player);
            $arena->reload();

            $arena->setAll([
                "name" => $arenaName,
                "waitingarea" => $waitingArea,
                "teams" => $teams,
                "player" => $player,
                "----" => "----",
                "status" => "lobby",
                "gamePlayer" => 0,
                "rotTeam" => 0,
                "gelbTeam" => 0,
                "grünTeam" => 0,
                "cyanTeam" => 0,
                "blauTeam" => 0,
                "magentaTeam" => 0,
                "schwarzTeam" => 0,
                "weißTeam" => 0,
                "startTime" => 61,
                "endTime" => 16
            ]);
            $arena->save();
        }
    }
}