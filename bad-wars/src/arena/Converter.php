<?php

declare(strict_types=1);

namespace BedWars\arena;

class Converter
{
    public function convertTeamToColor(string $team): string
    {
        if ($team === "1") return "rot";
        if ($team === "2") return "gelb";
        if ($team === "3") return "grün";
        if ($team === "4") return "cyan";
        if ($team === "5") return "blau";
        if ($team === "6") return "magenta";
        if ($team === "7") return "schwarz";
        if ($team === "8") return "weiß";

        return "error";
    }

    public function convertTeamToColorCode(string $team)
    {
        if ($team === "1") return "§cRot";
        if ($team === "2") return "§eGelb";
        if ($team === "3") return "§aGrün";
        if ($team === "4") return "§bCyan";
        if ($team === "5") return "§9Blau";
        if ($team === "6") return "§dMagenta";
        if ($team === "7") return "§0Schwarz";
        if ($team === "8") return "§fWeiß";

        return "error";
    }
}