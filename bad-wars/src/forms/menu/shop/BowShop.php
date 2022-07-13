<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;

class BowShop
{
    public function sendBowPage(Inventory $inventory): void
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
        $inventory->setItem(18, VanillaItems::BOW()->setCustomName("§7Bogen")->setLore(["§l§c1 Gold"]));
        $enchantment = new EnchantmentInstance(VanillaEnchantments::POWER(), 1);
        $inventory->setItem(19, VanillaItems::BOW()->setCustomName("§7Bogen 2")->setLore(["§l§c4 Gold"])->addEnchantment($enchantment));

        $inventory->setItem(21, VanillaItems::ARROW()->setCustomName("§7Pfeile")->setCount(2)->setLore(["§l§c1 Eisen"]));
    }
}