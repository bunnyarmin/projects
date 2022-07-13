<?php

declare(strict_types=1);

namespace SkyWars\arena;

use AssertionError;

class Converter
{
    public function convertTeamIntToTeamColor(string $team)
    {
        return match ($team) {
            "1" => "rot",
            "2" => "gelb",
            "3" => "grün",
            "4" => "cyan",
            "5" => "blau",
            "6" => "magenta",
            "7" => "schwarz",
            "8" => "weiß",
            default => throw new AssertionError("")
        };
    }

    public function convertTeamIntToColorCode(string $team)
    {
        return match ($team) {
            "1" => "§cRot",
            "2" => "§eGelb",
            "3" => "§aGrün",
            "4" => "§bCyan",
            "5" => "§9Blau",
            "6" => "§dMagenta",
            "7" => "§0Schwarz",
            "8" => "§fWeiß",
            default => throw new AssertionError("")
        };
    }

    public function convertTeamColorToTeamColorCode(string $team)
    {
        return match ($team) {
            "rot" => "§cRot",
            "gelb" => "§eGelb",
            "grün" => "§aGrün",
            "cyan" => "§bCyan",
            "blau" => "§9Blau",
            "magenta" => "§dMagenta",
            "schwarz" => "§0Schwarz",
            "weiß" => "§fWeiß",
            default => throw new AssertionError("")
        };
    }
}