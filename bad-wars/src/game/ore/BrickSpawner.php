<?php

declare(strict_types=1);

namespace BedWars\game\ore;

use BedWars\BedWars;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class BrickSpawner extends Task
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function onRun(): void
    {
        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
        $level = $this->plugin->getServer()->getWorldManager()->getWorldByName("BedWarsTest");

        if ($arena->get("status") === "ingame"){
            if ($arena->get("teams") === 2){
                $spawnerRot = $arena->get("brick.spawner.rot");

                $x = (int)$spawnerRot["x"];
                $y = (int)$spawnerRot["y"];
                $z = (int)$spawnerRot["z"];


                $pos = new Vector3($x, $y, $z);
                $level->dropItem($pos->asVector3(), ItemFactory::getInstance()->get(ItemIds::BRICK)->setCustomName("§7Bronze"));


                $spawnerGelb = $arena->get("brick.spawner.gelb");

                $x = (int)$spawnerGelb["x"];
                $y = (int)$spawnerGelb["y"];
                $z = (int)$spawnerGelb["z"];

                $pos = new Vector3($x, $y, $z);
                $level->dropItem($pos->asVector3(), ItemFactory::getInstance()->get(ItemIds::BRICK)->setCustomName("§7Bronze"));
            }
        }
    }
}