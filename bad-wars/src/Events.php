<?php

declare(strict_types=1);

namespace BedWars;

use BedWars\arena\Converter;
use BedWars\arena\setup\Villager;
use BedWars\forms\menu\VillagerShop;
use BedWars\game\form\TeamSelector;
use BedWars\game\player\Warper;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Events implements Listener
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
        $arena->set("gamePlayer", $arena->get("gamePlayer") + 1);
        $arena->set("team." . $player->getName(), "");
        $arena->save();

        $event->setJoinMessage("§fBed§cWars §8» §7Der Spieler §r" . $player->getDisplayName() . " §7hat die Runde betreten!");

        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->setHealth(20);
        $player->getHungerManager()->setFood(20);

        $player->getInventory()->setItem(4, VanillaBlocks::WOOL()->asItem()->setCustomName("§cTeam Selector"));
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();

        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
        $arena->set("gamePlayer", $arena->get("gamePlayer") - 1);
        $arena->save();

        $event->setQuitMessage("§fBed§cWars §8» §7Der Spieler §r" . $player->getDisplayName() . " §7hat die Runde verlassen!");
    }

    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();

        if ($item->getId() === ItemIds::WOOL) {
            $teamSelector = new TeamSelector($this->plugin);
            $form = $teamSelector->sendTeamSelectorGUI();
            $player->sendForm($form);
        }
    }

    public function onChat(PlayerChatEvent $event): void
    {
        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

        if ($arena->get("status") === "ingame"){
            $message = $event->getMessage();
            $word = explode(" ", $message);
            if ($word[0] === "@a"){
                //global chat
            }else{
                //basic chat
            }
        }
    }

    public function onDeath(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();

        $event->setDrops([]);
    }

    public function onRespawn(PlayerRespawnEvent $event): void
    {
        $player = $event->getPlayer();

        $warper = new Warper($this->plugin);
        $warper->teleportToSpawn($player);
    }

    public function onBreak(BlockBreakEvent $event): void
    {
        $block = $event->getBlock();

        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

        if ($arena->get("status") === "lobby") {
            $event->cancel();
        } elseif ($arena->get("status") === "ingame") {
            if ($block->getId() !== BlockLegacyIds::SANDSTONE or $block->getId() !== BlockLegacyIds::END_STONE or $block->getId() !== BlockLegacyIds::CHEST or $block->getId() !== BlockLegacyIds::LADDER) {
                $event->cancel();
            }elseif ($block->getId() === BlockLegacyIds::BED_BLOCK){
                $pos = $block->getPosition();

            }
        } elseif ($arena->get("status") === "end") {
            $event->cancel();
        }
    }

    public function onDamage(EntityDamageEvent $event): void
    {
        $entity = $event->getEntity();

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if ($entity instanceof Villager) {
                    $event->cancel();

                    $shop = new VillagerShop();
                    $shop->sendItemShop($damager);
                } elseif ($entity instanceof Player) {
                    $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
                    if ($arena->get("team." . $entity->getName()) === $arena->get("team." . $damager->getName())) {
                        $event->cancel();
                    }
                }
            }
        }
    }
}