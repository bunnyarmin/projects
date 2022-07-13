<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\Inventory;

class BlockShop
{
    public function sendBlockPage(Inventory $inventory): void
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
        $inventory->setItem(18, VanillaBlocks::SANDSTONE()->asItem()->setCustomName("§7Sandstein")->setCount(4)->setLore(["§l§c2 Bronze"]));
        $inventory->setItem(19, VanillaBlocks::END_STONE()->asItem()->setCustomName("§7End-Stein")->setLore(["§l§c6 Bronze"]));
        $inventory->setItem(20, VanillaBlocks::CHEST()->asItem()->setCustomName("§7Kiste")->setLore(["§l§c2 Eisen"]));

        $inventory->setItem(22, VanillaBlocks::LADDER()->asItem()->setCustomName("§7Leiter")->setCount(6)->setLore(["§l§c10 Bronze"]));
    }
}