<?php

declare(strict_types=1);

namespace ServerEngine\group;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class Group
{
    public function displayName(Player $player): void
    {
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
        $group = $pdata->get("group");
        $nick = $pdata->get("nick");

        if ($nick === "") {
            switch ($group) {
                case "Owner":
                case "Admin":
                    $player->setNameTag("§c" . $player->getName());
                    $player->setDisplayName("§c" . $player->getName());
                    break;
                case "Supporter":
                    $player->setNameTag("§a" . $player->getName());
                    $player->setDisplayName("§a" . $player->getName());
                    break;
                case "Architekt":
                    $player->setNameTag("§9" . $player->getName());
                    $player->setDisplayName("§9" . $player->getName());
                    break;
                case "Influencer":
                    $player->setNameTag("§d" . $player->getName());
                    $player->setDisplayName("§d" . $player->getName());
                    break;
                case "Premium":
                    $player->setNameTag("§6" . $player->getName());
                    $player->setDisplayName("§6" . $player->getName());
                    break;
                case "Spieler":
                    $player->setNameTag("§7" . $player->getName());
                    $player->setDisplayName("§7" . $player->getName());
                    break;
            }
        } else {
            $player->setNameTag("§7" . $nick);
            $player->setDisplayName("§7" . $nick);
        }
    }

    public function displayChat($event, Player $player): void
    {
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
        $group = $pdata->get("group");
        $nick = $pdata->get("nick");

        if ($nick === "") {
            switch ($group) {
                case "Owner":
                    $event->setFormat("§cOwner §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Admin":
                    $event->setFormat("§cAdmin §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Supporter":
                    $event->setFormat("§aSupporter §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Architekt":
                    $event->setFormat("§9Architekt §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Influencer":
                    $event->setFormat("§dInfluencer §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Premium":
                    $event->setFormat("§6Premium §8| §7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
                case "Spieler":
                    $event->setFormat("§7" . $player->getName() . " §8»§7 " . $event->getMessage());
                    break;
            }
        } else {
            $event->setFormat("§7" . $nick . " §8» §7" . $event->getMessage());
        }
    }
}