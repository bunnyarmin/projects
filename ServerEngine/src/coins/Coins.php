<?php

declare(strict_types=1);

namespace ServerEngine\coins;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class Coins
{
    public function getCoins(Player $player): int
    {
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
        return $pdata->get("coins");
    }

    //more soon
}