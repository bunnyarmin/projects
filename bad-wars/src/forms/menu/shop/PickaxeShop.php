<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;
use pocketmine\item\VanillaItems;

class PickaxeShop
{
    public function sendPickaxePage(Inventory $inventory): void
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
        $inventory->setItem(18, VanillaItems::WOODEN_PICKAXE()->setCustomName("§7Holz-Spitzhacke")->setLore(["§l§c4 Bronze"]));
        $inventory->setItem(19, VanillaItems::STONE_PICKAXE()->setCustomName("§7Stein-Spitzhacke")->setLore(["§l§c12 Bronze"]));
        $inventory->setItem(20, VanillaItems::IRON_PICKAXE()->setCustomName("§7Eisen-Spitzhacke")->setLore(["§l§c4 Eisen"]));
    }
}