<?php

declare(strict_types=1);

namespace ServerEngine;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use ServerEngine\chatfilter\ChatFilter;
use ServerEngine\group\Group;
use ServerEngine\permission\Permissions;

class Events implements Listener
{
    public function __construct(private Engine $plugin)
    {
    }

    public function onLogin(PlayerLoginEvent $event): void
    {
        $player = $event->getPlayer();

        if (!file_exists("/home/server/database/player/" . $player->getName() . ".json")) {
            $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
            $pdata->set("group", "Spieler");
            $pdata->set("nick", "");
            $pdata->set("server", "Lobby");
            $pdata->set("coins", 1000);
            $pdata->set("ban", "false");
            $pdata->set("ban-time", 0);
            $pdata->set("ban-reason", "");
            $pdata->set("ban-sreason", "");
            $pdata->set("mute", "false");
            $pdata->set("mute-time", 0);
            $pdata->set("mute-reason", "");
            $pdata->set("mute-sreason", "");
            $pdata->save();
        } else {
            $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);
            if ($pdata->get("ban") === "true") {
                $time = time();
                if ($pdata->get("ban-time") < $time) {
                    $pdata->set("ban", "false");
                    $pdata->set("ban-time", 0);
                    $pdata->set("ban-reason", "");
                    $pdata->save();
                } else {
                    $reason = $pdata->get("ban-reason");
                    $player->kick("§8»  §6BunnyGames  §8«" . "\n" . "§cDu bist gebannt!" . "\n" . "§7Schaue die Kontaktmöglichkeiten unter §eBunnyGames.de §7an" . "\n" . "um eventuelle Rückfragen zu klären!" . "\n\n" . "§cGrund§8: §c" . $reason);
                }
            }
        }
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        $event->setJoinMessage("");

        $group = new Group();
        $group->displayName($player);

        $permission = new Permissions($this->plugin);
        $permission->givePermission($player);
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $event->setQuitMessage("");
    }

    public function onChat(PlayerChatEvent $event): void
    {
        $player = $event->getPlayer();
        $pdata = new Config("/home/server/database/player/" . $player->getName() . ".json", Config::JSON);

        if ($pdata->get("mute") === "true") {
            $time = time();
            if ($pdata->get("mute-time") < $time) {
                $pdata->set("mute", "false");
                $pdata->set("mute-time", 0);
                $pdata->set("mute-reason", "");
                $pdata->save();
            } else {
                $event->cancel();

                $reason = $pdata->get("mute-reason");
                $player->sendMessage("§6BunnyGames §8» §cDu bist gemuted!" . "\n" . "§cGrund§8: §c" . $reason);
            }
        } else {
            $filter = new ChatFilter();

            $message = $event->getMessage();
            $lowercaseMessage = strtolower($message);
            $bannedWords = ["hund", "hurensohn", "hure", "schwuchtel", "scheiß", "idiot", "arsch", "arschloch", "nazi", "ausländer", "auslända"];

            if ($filter->filterBadWords($lowercaseMessage, $bannedWords) !== false) {
                $event->cancel();
                $player->sendMessage("§6BunnyGames §8» §cAchte auf deine Wortwahl!!");
            } else {
                $group = new Group();
                $group->displayChat($event, $player);
            }
        }
    }
}