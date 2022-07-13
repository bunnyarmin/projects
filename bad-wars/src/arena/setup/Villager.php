<?php

declare(strict_types=1);

namespace BedWars\arena\setup;

use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;

class Villager extends \pocketmine\entity\Villager
{
    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);

        $this->setNameTag("§cShop");
        $this->setNameTagAlwaysVisible();
    }
}