<?php

declare(strict_types=1);

namespace ServerEngine\more;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Label;

class PDataForm
{
    public function createPlayerDataForm(string $playername): CustomForm
    {
        $pdata = new Config("/home/server/database/player/" . $playername . ".json", Config::JSON);
        $group = $pdata->get("group");
        $nick = $pdata->get("nick");
        $server = $pdata->get("server");
        $coins = $pdata->get("coins");
        $ban = $pdata->get("ban");
        $mute = $pdata->get("mute");

        return new CustomForm(
            "§7" . $playername, [
            new Label("label", "
                Gruppe: " . $group . "
                Nick: " . $nick . "
                Server: " . $server . "
                Coins: " . $coins . "
                Ban: " . $ban . "
                Mute: " . $mute)
        ],
            function (Player $submitter, CustomFormResponse $response): void {
            }
        );
    }
}