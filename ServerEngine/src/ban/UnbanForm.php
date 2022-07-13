<?php

declare(strict_types=1);

namespace ServerEngine\ban;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Input;

class UnbanForm
{
    public function createUnbanForm(): CustomForm
    {
        return new CustomForm(
            "Unban", [
            new Input("input", "Spieler", "xXTMSPlaysXx")
        ],
            function (Player $submitter, CustomFormResponse $response): void {
                $pplayer = $response->getString("input");

                if (file_exists("/home/server/database/player/" . $pplayer . ".json")) {
                    $pdata = new Config("/home/server/database/player/" . $pplayer . ".json", Config::JSON);
                    if ($pdata->get("ban") === "true") {
                        $pdata->set("ban", "false");
                        $pdata->set("ban-time", 0);
                        $pdata->set("ban-reason", "");
                        $pdata->set("ban-sreason", "");
                        $pdata->save();

                        $submitter->sendMessage("§aDu hast " . $pplayer . " entbannt.");
                    } else {
                        $submitter->sendMessage("§c" . $pplayer . " ist derzeit nicht gebannt.");
                    }
                } else {
                    $submitter->sendMessage("§c" . $pplayer . " hat noch nie auf BunnyGames gespielt!");
                }
            }
        );
    }
}