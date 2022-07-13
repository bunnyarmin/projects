<?php

declare(strict_types=1);

namespace ServerEngine\mute;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\Engine;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Dropdown;
use ServerEngine\pmforms\element\Input;

class MuteForm
{
    public function __construct(private Engine $plugin)
    {
    }

    public function createMuteForm(): CustomForm
    {
        return new CustomForm(
            "Mute", [
            new Input("input", "Spieler", "xXTMSPlaysXx"),
            new Dropdown("dropdown", "Grund", [
                "§cBeleidigung §8[§710d§8]", "§cWerbung §8[§75d§8]", "§cSonstiges §8[§73d§8]"
            ]),
            new Input("input2", "Falls Sonstiges", "Er war gemein")
        ],
            function (Player $submitter, CustomFormResponse $response): void {
                $pplayer = $response->getString("input");
                $grund = $response->getInt("dropdown");
                $sgrund = $response->getString("input2");

                if (file_exists("/home/server/database/player/" . $pplayer . ".json")) {
                    $pdata = new Config("/home/server/database/player/" . $pplayer . ".json", Config::JSON);
                    $player = $this->plugin->getServer()->getPlayerExact($pplayer);

                    switch ($grund) {
                        case 0:
                            $now = time();
                            $day = (10 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("mute", "true");
                            $pdata->set("mute-time", $banTime);
                            $pdata->set("mute-reason", "Beleidigung");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gemuted.");

                            if ($player->isOnline()) {
                                $player->sendMessage("§6BunnyGames §8» §cDu wurdest gemuted!");
                            }
                            break;
                        case 1:
                            $now = time();
                            $day = (5 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("mute", "true");
                            $pdata->set("mute-time", $banTime);
                            $pdata->set("mute-reason", "Werbung");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gemuted.");

                            if ($player->isOnline()) {
                                $player->sendMessage("§6BunnyGames §8» §cDu wurdest gemuted!");
                            }
                            break;
                        case 2:
                            $now = time();
                            $day = (3 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("mute", "true");
                            $pdata->set("mute-time", $banTime);
                            $pdata->set("mute-reason", "Sonstiges");
                            $pdata->set("mute-sreason", $sgrund);
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gemuted.");

                            if ($player->isOnline()) {
                                $player->sendMessage("§6BunnyGames §8» §cDu wurdest gemuted!");
                            }
                            break;
                    }
                } else {
                    $submitter->sendMessage("§c" . $pplayer . " hat noch nie auf BunnyGames gespielt!");
                }
            }
        );
    }
}