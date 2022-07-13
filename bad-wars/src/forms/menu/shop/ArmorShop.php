<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;
use pocketmine\item\VanillaItems;

class ArmorShop
{
    public function sendArmorPage(Inventory $inventory): void
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
        $inventory->setItem(18, VanillaItems::LEATHER_CAP()->setCustomName("§7Kappe")->setLore(["§l§c1 Eisen"]));
        $inventory->setItem(19, VanillaItems::LEATHER_PANTS()->setCustomName("§7Leggings")->setLore(["§l§c1 Eisen"]));
        $inventory->setItem(20, VanillaItems::LEATHER_BOOTS()->setCustomName("§7Schuhe")->setLore(["§l§c1 Eisen"]));

        $inventory->setItem(22, VanillaItems::CHAINMAIL_CHESTPLATE()->setCustomName("§7Ketten-Brustplatte")->setLore(["§l§c3 Eisen"]));
        $inventory->setItem(23, VanillaItems::IRON_CHESTPLATE()->setCustomName("§7Eisen-Brustplatte")->setLore(["§l§c6 Eisen"]));
    }
}