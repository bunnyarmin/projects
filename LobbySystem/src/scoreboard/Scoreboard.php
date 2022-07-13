<?php

declare(strict_types=1);

namespace LobbySystem\scoreboard;

use pocketmine\player\Player;

class Scoreboard
{
    public function sendScoreboard(Player $player): void
    {
        ScoreboardAPI::removeScoreboard($player);
        ScoreboardAPI::createScoreboard(" §6BunnyGames ", $player);
        ScoreboardAPI::setLine(0, "§1", $player);
        ScoreboardAPI::setLine(1, " §8» §eCoins ", $player);
        ScoreboardAPI::setLine(2, " blabla ", $player);
    }
}