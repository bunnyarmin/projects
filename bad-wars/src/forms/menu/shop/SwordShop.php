<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;

class SwordShop
{
    public function sendSwordPage(Inventory $inventory): void
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
        $enchantment1 = new EnchantmentInstance(VanillaEnchantments::KNOCKBACK(), 1);
        $inventory->setItem(18, VanillaItems::STICK()->setCustomName("§7Stick")->addEnchantment($enchantment1)->setLore(["8 Bronze"]));
        $enchantment2 = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $inventory->setItem(19, VanillaItems::GOLDEN_SWORD()->setCustomName("§7Gold-Schwert")->addEnchantment($enchantment2)->setLore(["2 Eisen"]));
        $inventory->setItem(20, VanillaItems::IRON_SWORD()->setCustomName("§7Eisen-Schwert")->addEnchantment($enchantment2)->setLore(["6 Gold"]));
    }
}