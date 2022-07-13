<?php

declare(strict_types=1);

namespace BedWars\arena\setup;

use BedWars\BedWars;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class WaitingArea
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function setWaitingArea(Player $sender, string $arenaName, string $worldName): void
    {
        if (is_dir($this->plugin->getServer()->getDataPath() . "worlds/" . $worldName)) {
            $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
            $arena->set("waitingarea", $worldName);
            $arena->save();

            $level = $this->plugin->getServer()->getWorldManager()->getWorldByName($worldName);
            $this->plugin->getServer()->getWorldManager()->setDefaultWorld($level);

            $sender->sendMessage("§fBed§cWars §8» §aFür die Arena " . $arenaName . " wurde die Welt " . $worldName . " als Wartelobby zugeteilt!");
            $sender->sendMessage("§fBed§cWars §8» §7Setze nun die Spieler Spawnpunkte!");
        } else {
            $sender->sendMessage("§fBed§cWars §8» §cDie Welt " . $worldName . " gibt es nicht!");
        }
    }
}