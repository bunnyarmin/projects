<?php

declare(strict_types=1);

namespace BedWars\setup;

use pocketmine\entity\Location;
use pocketmine\entity\Villager;
use pocketmine\nbt\tag\CompoundTag;

class SpawnVillager extends Villager
{
    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);

        $this->setNameTag("§cShop");
        $this->setNameTagAlwaysVisible();
    }
}