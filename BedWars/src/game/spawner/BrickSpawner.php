<?php

declare(strict_types=1);

namespace BedWars\game\spawner;

use BedWars\Game;
use pocketmine\block\tile\Sign;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class BrickSpawner extends Task
{
    public function __construct(private Game $plugin)
    {
    }

    //testing
    public function onRun(): void
    {
        $serverconfig = new Config($this->plugin->getDataFolder() . "ServerData.json", Config::JSON);
        $arena = $serverconfig->get("arena");

        $this->plugin->getServer()->getWorldManager()->loadWorld($arena);

        $level = $this->plugin->getServer()->getWorldManager()->getWorldByName($arena);

        $block = $level->getBlock(VanillaBlocks::IRON_ORE()->getPosition()->asVector3());
        $x = $block->getPosition()->getFloorX();
        $y = $block->getPosition()->getFloorY();
        $z = $block->getPosition()->getFloorZ();
        $level->dropItem(new Position($x, $y, $z, $level), ItemFactory::getInstance()->get(ItemIds::BRICK)->setCustomName("test"));

        $tile = VanillaBlocks::SPRUCE_WALL_SIGN();
        if ($level->getTile($tile->getPositio)
    }
}