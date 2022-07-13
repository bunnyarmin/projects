<?php

declare(strict_types=1);

namespace BedWars;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class Events implements Listener
{
    public function __construct(private Game $plugin)
    {
    }

    public function onJoin(PlayerJoinEvent $event): void
    {

    }
}