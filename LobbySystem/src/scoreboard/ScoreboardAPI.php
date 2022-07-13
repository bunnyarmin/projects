<?php

declare(strict_types=1);

namespace LobbySystem\scoreboard;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class ScoreboardAPI
{
    public static function createScoreboard(string $displayName, Player $player): void
    {
        $packet = SetDisplayObjectivePacket::create("sidebar", "{$player->getId()}", $displayName, "dummy", 0);
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public static function removeScoreboard(Player $player): void
    {
        $packet = RemoveObjectivePacket::create("{$player->getId()}");
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public static function setLine(int $line, string $content, Player $player): void
    {
        $entry = new ScorePacketEntry();
        $entry->scoreboardId = $line;
        $entry->objectiveName = "{$player->getId()}";
        $entry->score = $line;
        $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
        $entry->customName = " " . $content . " ";

        $packet = SetScorePacket::create(SetScorePacket::TYPE_CHANGE, [$entry]);
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public static function removeLine(int $line, Player $player): void
    {
        $entry = new ScorePacketEntry();
        $entry->scoreboardId = $line;
        $entry->objectiveName = "{$player->getId()}";
        $entry->score = $line;
        $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

        $packet = SetScorePacket::create(SetScorePacket::TYPE_REMOVE, [$entry]);
        $player->getNetworkSession()->sendDataPacket($packet);
    }
}