<?php

declare(strict_types=1);

namespace BedWars\setup;

use BedWars\arena\TeamConverter;
use BedWars\Game;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class SpawnSetup
{
    public function __construct(private Game $plugin)
    {
    }

    public function setSpawn(Player $sender, string $arenaName, string $team): void
    {
        if (file_exists($this->plugin->getDataFolder() . "/{$arenaName}/ArenaData.json")) {
            $posX = $sender->getPosition()->getFloorX();
            $posY = $sender->getPosition()->getFloorY();
            $posZ = $sender->getPosition()->getFloorZ();

            $converter = new TeamConverter();
            $color = $converter->convertTeamIntToTeamColor($team);

            $arenaconfig = new Config($this->plugin->getDataFolder() . "/{$arenaName}/ArenaData.json", Config::JSON);
            $arenaconfig->set("team.{$color}.spawn.x", $posX);
            $arenaconfig->set("team.{$color}.spawn.y", $posY);
            $arenaconfig->set("team.{$color}.spawn.z", $posZ);
            $arenaconfig->save();

            $tcolor = $converter->convertTeamIntToTeamColorCode($team);
            $sender->sendMessage("§fBed§cWars §8» §7Du hast den Spawn von Team {$tcolor} §7gesetzt!");
        } else {
            $sender->sendMessage("§fBed§cWars §8» §7Es gibts keine Arena unter dem Namen {$arenaName}!");
        }
    }
}