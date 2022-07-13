<?php

declare(strict_types=1);

namespace ServerEngine\group;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class Nick
{
    public function nick(Player $player): void
    {
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);

        if ($pdata->get("nick") === "") {
            $nicks = ["tryh4rd", "ObieOfAspen", "Se4ik", "AverageDrake", "CinskyZizala", "Phyver", "soloBedless", "Lui_Kurenai", "Leohes", "Onix44", "21ok", "_Ayao", "bl6ckass", "Madara_Pro", "Dan1996", "OneplusLP", "HandyFreak21", "BedWarsKing2009", "SamuVT", "heeis", "Tezii", "DemonenSLayer", "FurkanGSG", "FurkanGHG", "JordxnnYT", "GSGUnity", "PrimaryGSG", "SnakeGSG"];
            $random = array_rand($nicks);
            $randomNick = $nicks[$random];

            $pdata->set("nick", $randomNick);
            $pdata->save();

            $player->setNameTag("§7" . $randomNick);
            $player->setDisplayName("§7" . $randomNick);

            $player->sendMessage("§6BunnyGames §8» §7Du wurdest zu §a" . $randomNick . " §7genickt!");
        } else {
            $pdata->set("nick", "");
            $pdata->save();

            switch ($pdata->get("group")) {
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
            $player->sendMessage("§6BunnyGames §8» §7Dein Nick wurde entfernt!");
        }
    }
}