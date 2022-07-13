<?php

declare(strict_types=1);

namespace ServerEngine\mute;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\Engine;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Input;

class UnmuteForm
{
    public function __construct(private Engine $plugin)
    {
    }

    public function createUnmuteForm(): CustomForm
    {
        return new CustomForm(
            "Unmute", [
            new Input("input", "Spieler", "xXTMSPlaysXx")
        ],
            function (Player $submitter, CustomFormResponse $response): void {
                $pplayer = $response->getString("input");

                if (file_exists("/home/server/database/player/" . $pplayer . ".json")) {
                    $pdata = new Config("/home/server/database/player/" . $pplayer . ".json", Config::JSON);
                    $player = $this->plugin->getServer()->getPlayerExact($pplayer);
                    if ($pdata->get("mute") === "true") {
                        $pdata->set("mute", "false");
                        $pdata->set("mute-time", 0);
                        $pdata->set("mute-reason", "");
                        $pdata->set("mute-sreason", "");
                        $pdata->save();

                        $submitter->sendMessage("§aDu hast " . $pplayer . " entmuted.");

                        if ($player->isOnline()) {
                            $player->sendMessage("§6BunnyGames §8» §aDu wurdest entmuted!");
                        }
                    } else {
                        $submitter->sendMessage("§c" . $pplayer . " ist derzeit nicht gemuted.");
                    }
                } else {
                    $submitter->sendMessage("§c" . $pplayer . " hat noch nie auf BunnyGames gespielt!");
                }
            }
        );
    }
}