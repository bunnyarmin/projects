<?php

declare(strict_types=1);

namespace ServerEngine\permission;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use ServerEngine\Engine;

class Permissions
{
    public function __construct(private Engine $plugin)
    {
    }

    public function givePermission(Player $player): void
    {
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
        $group = $pdata->get("group");

        switch ($group) {
            case "Owner":
            case "Admin":
                $player->addAttachment($this->plugin, "serverengine.group", true);
                $player->addAttachment($this->plugin, "serverengine.nick", true);
                $player->addAttachment($this->plugin, "serverengine.eban", true);
                $player->addAttachment($this->plugin, "serverengine.eunban", true);
                $player->addAttachment($this->plugin, "serverengine.emute", true);
                $player->addAttachment($this->plugin, "serverengine.eunmute", true);
                $player->addAttachment($this->plugin, "serverengine.pdata", true);
                break;
            case "Supporter":
                $player->addAttachment($this->plugin, "serverengine.nick", true);
                $player->addAttachment($this->plugin, "serverengine.eban", true);
                $player->addAttachment($this->plugin, "serverengine.emute", true);
                break;
            case "Architekt":
            case "Influencer":
            case "Premium":
                $player->addAttachment($this->plugin, "serverengine.nick", true);
                break;
        }
    }
}