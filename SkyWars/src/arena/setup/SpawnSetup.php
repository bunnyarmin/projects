<?php

declare(strict_types=1);

namespace SkyWars\arena\setup;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use SkyWars\arena\Converter;
use SkyWars\Game;

class SpawnSetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function setSpawn(Player $sender, string $arenaName, string $team): void
    {
        if (file_exists("/home/server/database/skywars/arena/{$arenaName}/Arena.json")) {
            $arena = new Config("/home/server/database/skywars/arena/{$arenaName}/ArenaData.json", Config::JSON);

            $posX = $sender->getPosition()->getFloorX();
            $posY = $sender->getPosition()->getFloorY();
            $posZ = $sender->getPosition()->getFloorZ();

            $converter = new Converter();
            $color = $converter->convertTeamIntToTeamColor($team);

            $arena->set("spawn.{$color}.x", $posX);
            $arena->set("spawn.{$color}.y", $posY);
            $arena->set("spawn.{$color}.z", $posZ);
            $arena->save();

            $tcolor = $converter->convertTeamIntToColorCode($team);

            $sender->sendMessage("§bSkyWars §8» §7Du hast den Spawn von Team {$tcolor} §7markiert!");
        } else {
            $sender->sendMessage("§bSkyWars §8» §7Die Arena {$arenaName} gibt es nicht!");
        }
    }
}