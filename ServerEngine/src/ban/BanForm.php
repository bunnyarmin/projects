<?php

declare(strict_types=1);

namespace ServerEngine\ban;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\Engine;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Dropdown;
use ServerEngine\pmforms\element\Input;

class BanForm
{
    public function __construct(private Engine $plugin)
    {
    }

    public function createBanForm(): CustomForm
    {
        return new CustomForm(
            "Ban", [
            new Input("input", "Spieler", "xXTMSPlaysXx"),
            new Dropdown("dropdown", "Grund", [
                "§cHacking §8[§730d§8]", "§cBeleidgung §8[§710d§8]", "§cWerbung §8[§72d§8]", "§cSonstiges §8[§75d§8]"
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
                            $day = (30 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("ban", "true");
                            $pdata->set("ban-time", $banTime);
                            $pdata->set("ban-reason", "Hacking");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gebannt.");

                            if ($player->isOnline()) {
                                $player->kick("§6BunnyGames §8» §cDu wurdest gebannt!");
                            }
                            break;
                        case 1:
                            $now = time();
                            $day = (10 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("ban", "true");
                            $pdata->set("ban-time", $banTime);
                            $pdata->set("ban-reason", "Beleidigung");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gebannt.");

                            if ($player->isOnline()) {
                                $player->kick("§6BunnyGames §8» §cDu wurdest gebannt!");
                            }
                            break;
                        case 2:
                            $now = time();
                            $day = (2 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("ban", "true");
                            $pdata->set("ban-time", $banTime);
                            $pdata->set("ban-reason", "Werbung");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gebannt.");

                            if ($player->isOnline()) {
                                $player->kick("§6BunnyGames §8» §cDu wurdest gebannt!");
                            }
                            break;
                        case 3:
                            $now = time();
                            $day = (5 * 86400);

                            $banTime = $now + $day;

                            $pdata->set("ban", "true");
                            $pdata->set("ban-time", $banTime);
                            $pdata->set("ban-reason", "Sonstiges");
                            $pdata->set("ban-sreason", $sgrund);
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast " . $pplayer . " gebannt.");

                            if ($player->isOnline()) {
                                $player->kick("§6BunnyGames §8» §cDu wurdest gebannt!");
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