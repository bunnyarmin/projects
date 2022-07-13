<?php

declare(strict_types=1);

namespace SkyWars\arena;

use pocketmine\block\VanillaBlocks;
use pocketmine\block\Wool;
use pocketmine\item\VanillaItems;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use SkyWars\Game;

class SPlayer
{
    public function __construct(private Game $plugin)
    {
    }

    public function restoreAll(Player $player): void
    {
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->setHealth(20);
        $player->getHungerManager()->setFood(20);
        $player->getXpManager()->setXpLevel(0);
        $player->setGamemode(GameMode::SURVIVAL());
    }

    public function giveLobbyItems(Player $player): void
    {
        $player->getInventory()->setItem(1, VanillaBlocks::CHEST()->asItem()->setCustomName("§cKits"));
        $player->getInventory()->setItem(7, VanillaBlocks::WOOL()->asItem()->setCustomName("§6Team"));
    }

    public function giveSpectatorItems(Player $player): void
    {
        $player->getInventory()->setItem(4, VanillaItems::COMPASS()->setCustomName("§cTeleporter"));
    }
}