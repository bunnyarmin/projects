<?php

declare(strict_types=1);

namespace BedWars\forms\menu\shop;

use pocketmine\inventory\Inventory;

class SpecialShop
{
    public function sendSpecialPage(Inventory $inventory): void
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
    }
}