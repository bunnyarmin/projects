<?php

declare(strict_types=1);

namespace ServerEngine\group;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\Engine;
use ServerEngine\pmforms\CustomForm;
use ServerEngine\pmforms\CustomFormResponse;
use ServerEngine\pmforms\element\Dropdown;
use ServerEngine\pmforms\element\Input;

class GroupForm
{
    public function __construct(private Engine $plugin)
    {
    }

    public function createGroupForm(): CustomForm
    {
        return new CustomForm(
            "Group", [
            new Input("input", "Spieler", "xXTMSPlaysXx"),
            new Dropdown("dropdown", "Rang", [
                "§cOwner", "§cAdmin", "§aSupporter", "§9Architekt", "§dInfluencer", "§6Premium", "§7Spieler"
            ])
        ],
            function (Player $submitter, CustomFormResponse $response): void {
                $pplayer = $response->getString("input");
                $group = $response->getInt("dropdown");

                if (file_exists("/home/server/database/player/" . $pplayer . ".json")) {
                    $pdata = new Config("/home/server/database/player/" . $pplayer . ".json", Config::JSON);
                    $player = $this->plugin->getServer()->getPlayerExact($pplayer);
                    switch ($group) {
                        case 0:
                            $pdata->set("group", "Owner");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §cOwner §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§c" . $player->getName());
                                $player->setDisplayName("§c" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §cOwner §7Rang erhalten!");
                            }
                            break;
                        case 1:
                            $pdata->set("group", "Admin");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §cAdmin §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§c" . $player->getName());
                                $player->setDisplayName("§c" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §cAdmin §7Rang erhalten!");
                            }
                            break;
                        case 2:
                            $pdata->set("group", "Supporter");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §aSupporter §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§a" . $player->getName());
                                $player->setDisplayName("§a" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §aSupporter §7Rang erhalten!");
                            }
                            break;
                        case 3:
                            $pdata->set("group", "Architekt");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §9Architekt §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§9" . $player->getName());
                                $player->setDisplayName("§9" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §9Architekt §7Rang erhalten!");
                            }
                            break;
                        case 4:
                            $pdata->set("group", "Influencer");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §dInfluencer §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§d" . $player->getName());
                                $player->setDisplayName("§d" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §dInfluencer §7Rang erhalten!");
                            }
                            break;
                        case 5:
                            $pdata->set("group", "Premium");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §6Premium §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§6" . $player->getName());
                                $player->setDisplayName("§6" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §6Premium §7Rang erhalten!");
                            }
                            break;
                        case 6:
                            $pdata->set("group", "Spieler");
                            $pdata->save();

                            $submitter->sendMessage("§aDu hast §7" . $pplayer . " §aden §7Spieler §aRang gegeben!");

                            if ($player->isOnline()) {
                                $player->setNameTag("§7" . $player->getName());
                                $player->setDisplayName("§7" . $player->getName());

                                $player->sendMessage("§6BunnyGames §8» §7Du hast den §7Spieler §7Rang erhalten!");
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