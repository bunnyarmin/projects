<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;
use pocketmine\item\VanillaItems;

class SnackShop
{
    public function sendSnackPage(Inventory $inventory): void
    {
        $inventory->clear(18);
        $inventory->clear(19);
        $inventory->clear(20);
        $inventory->clear(21);
        $inventory->clear(22);
        $inventory->clear(23);
        $inventory->clear(24);
        $inventory->clear(25);
        $inventory->clear(26);

        //3 Line
        $inventory->setItem(18, VanillaItems::BREAD()->setCustomName("§7Brot")->setLore(["§l§c1 Bronze"]));
        $inventory->setItem(19, VanillaItems::COOKED_PORKCHOP()->setCustomName("§7Haram Fleisch")->setLore(["§l§c3 Bronze"]));
        $inventory->setItem(20, VanillaItems::GOLDEN_APPLE()->setCustomName("§7Goldener Apfel")->setLore(["§l§c2 Gold"]));
    }
}