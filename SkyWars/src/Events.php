<?php

declare(strict_types=1);

namespace SkyWars;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use SkyWars\arena\SPlayer;

class Events implements Listener
{
    private array $lastDamager = [];

    public function __construct(private Game $plugin)
    {
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        $splayer = new SPlayer($this->plugin);
        $splayer->restoreAll($player);
        $splayer->giveLobbyItems($player);

        $getarena = new Config($this->plugin->getDataFolder() . "GetArena.json", Config::JSON);
        $arenaName = $getarena->get("arena");
        $arena = new Config("/home/server/database/skywars/arena/{$arenaName}/Arena.json", Config::JSON);
        $arena->set();
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();
    }

    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
    }

    public function onDeath(PlayerDeathEvent $event): void
    {
        $event->setDeathMessage("");
    }

    public function onEntityDamage(EntityDamageEvent $event): void
    {
        $entity = $event->getEntity();

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if ($entity instanceof Player and $damager instanceof Player) {
                $this->lastDamager[$entity->getName()] = $damager->getName();
                if ($event->getFinalDamage() >= $entity->getHealth()) {
                    $event->cancel();

                    $splayer = new SPlayer($this->plugin);
                    $splayer->restoreAll($entity);
                    $splayer->giveSpectatorItems($entity);

                    $entity->setGamemode(GameMode::SPECTATOR());
                    $entity->teleport($damager->getPosition()->asVector3());

                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer) {
                        $onlinePlayer->sendMessage("§bSkyWars §8» §7{$entity->getName()} wurde von {$damager->getName()} getötet!");
                    }
                    unset($this->lastDamager[$entity->getName()]);
                }
            }
        } elseif ($event->getCause() === $event::CAUSE_VOID) {
            if ($entity instanceof Player) {
                $lastDamager = $this->lastDamager[$entity->getName()];
                $damager = $this->plugin->getServer()->getPlayerExact($lastDamager);

                $event->cancel();

                $splayer = new SPlayer($this->plugin);
                $splayer->restoreAll($entity);
                $splayer->giveSpectatorItems($entity);

                $entity->setGamemode(GameMode::SPECTATOR());
                $entity->teleport($damager->getPosition()->asVector3());

                foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer) {
                    $onlinePlayer->sendMessage("§bSkyWars §8» §7{$entity->getName()} wurde von {$damager->getName()} getötet!");
                }
                unset($this->lastDamager[$entity->getName()]);
            }
        }
    }
}