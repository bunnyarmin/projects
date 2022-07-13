<?php

declare(strict_types=1);

namespace LobbySystem;

use LobbySystem\forms\GadgetForm;
use LobbySystem\forms\NavigatorForm;
use LobbySystem\scoreboard\Scoreboard;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use pocketmine\utils\Config;

class Events implements Listener
{
    public function __construct(private Lobby $plugin)
    {
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        if (!file_exists($this->plugin->getDataFolder() . $player->getName() . ".json")){
            $pdata = new Config($this->plugin->getDataFolder() . $player->getName() . ".json", Config::JSON);
            $pdata->set("gadget", "");
            $pdata->save();
        }

        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->setHealth(20);
        $player->getHungerManager()->setFood(20);
        $player->getHungerManager()->setEnabled(false);
        $player->getXpManager()->setXpLevel(0);

        $scoreboard = new Scoreboard();
        $scoreboard->sendScoreboard($player);

        $player->getInventory()->setItem(1, VanillaItems::BLAZE_ROD()->setCustomName("Spieler verstecken"));
        $player->getInventory()->setItem(4, VanillaItems::COMPASS()->setCustomName("Navigator"));
        $player->getInventory()->setItem(7, VanillaBlocks::ENDER_CHEST()->asItem()->setCustomName("Gadgets"));
    }

    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();

        switch ($item->getId()) {
            case ItemIds::BLAZE_ROD:
                if ($event->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK) {
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer) {
                        $player->hidePlayer($onlinePlayer);
                    }

                    $player->getInventory()->remove(VanillaItems::BLAZE_ROD());
                    $player->getInventory()->setItem(1, VanillaItems::STICK()->setCustomName("Spieler anzeigen"));

                    $player->sendMessage("§6BunnyGames §8» §7Du hast nun alle Spieler versteckt!");
                }
                break;
            case ItemIds::STICK:
                if ($event->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK) {
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer) {
                        $player->showPlayer($onlinePlayer);
                    }

                    $player->getInventory()->remove(VanillaItems::STICK());
                    $player->getInventory()->setItem(1, VanillaItems::BLAZE_ROD()->setCustomName("Spieler verstecken"));

                    $player->sendMessage("§6BunnyGames §8» §7Du kannst nun alle Spieler wieder sehen!");
                }
                break;
            case ItemIds::COMPASS:
                $formFile = new NavigatorForm($this->plugin);
                $form = $formFile->createNavigationForm();
                $player->sendForm($form);
                break;
            case ItemIds::ENDER_CHEST:
                $formFile = new GadgetForm($this->plugin);
                $form = $formFile->createGadgetForm();
                $player->sendForm($form);
                break;
        }
    }

    public function onItemDrop(PlayerDropItemEvent $event): void
    {
        $event->cancel();
    }

    public function onInventoryTransaction(InventoryTransactionEvent $event): void
    {
        $event->cancel();
    }

    public function onBlockBreak(BlockBreakEvent $event): void
    {
        $event->cancel();
    }

    public function onBlockPlace(BlockPlaceEvent $event): void
    {
        $event->cancel();
    }

    public function onDeath(PlayerDeathEvent $event): void
    {
        $event->setDrops([]);
        $event->setDeathMessage("");
    }

    public function onDamaga(EntityDamageEvent $event): void
    {
        $event->cancel();
        if ($event instanceof EntityDamageByEntityEvent) $event->cancel();
    }
}