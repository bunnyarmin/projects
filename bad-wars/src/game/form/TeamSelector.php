<?php

declare(strict_types=1);

namespace BedWars\game\form;

use BedWars\apis\pmforms\FormIcon;
use BedWars\apis\pmforms\MenuForm;
use BedWars\apis\pmforms\MenuOption;
use BedWars\arena\Converter;
use BedWars\BedWars;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class TeamSelector
{
    public function __construct(private BedWars $plugin)
    {
    }

    public function sendTeamSelectorGUI(): MenuForm
    {
        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);

        return new MenuForm(
            "§cSelect Team",
            " ",
            [
                new MenuOption("§cRot", new FormIcon("textures/blocks/wool_colored_red.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§eGelb", new FormIcon("textures/blocks/wool_colored_yellow.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§aGrün", new FormIcon("textures/blocks/wool_colored_green.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§bCyan", new FormIcon("textures/blocks/wool_colored_cyan.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§9Blau", new FormIcon("textures/blocks/wool_colored_blue.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§dMagenta", new FormIcon("textures/blocks/wool_colored_magenta.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§0Schwarz", new FormIcon("textures/blocks/wool_colored_black.png", FormIcon::IMAGE_TYPE_PATH)),
                new MenuOption("§fWeiß", new FormIcon("textures/blocks/wool_colored_white.png", FormIcon::IMAGE_TYPE_PATH))
            ],
            function (Player $submitter, int $selected): void {
                $team = $selected + 1;

                $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
                $teams = $arena->get("teams");

                $colorCode = new Converter();

                if ($selected < $teams){
                    self::setTeam($submitter, $team);
                }else{
                    $submitter->sendMessage("§fBed§cWars §8» §7Das Team §r" . $colorCode->convertTeamToColorCode((string)$team) . " §7ist nicht auswählbar!");
                }
            }
        );
    }

    public function setTeam(Player $submitter, int $team): void
    {
        $converter = new Converter();
        $teamC = $converter->convertTeamToColor((string)$team);

        $arena = new Config($this->plugin->getDataFolder() . "Arena.json", Config::JSON);
        $selTeam = $arena->get($teamC . "Team");
        $ppt = $arena->get("player");
        $player = $arena->get("team." . $submitter->getName());

        $colorCode = new Converter();

        if ($selTeam < $ppt) {
            if ($player === "") {
                $arena->set($teamC . "Team", $selTeam + 1);
                $arena->set("team." . $submitter->getName(), $teamC);
                $arena->save();

                $submitter->sendMessage("§fBed§cWars §8» §7Du bist nun in Team §r" . $colorCode->convertTeamToColorCode((string)$team) . "§7!");
            } else {
                $oldTeam = $arena->get("team." . $submitter->getName());
                $getOldTeam = $arena->get($oldTeam . "Team");

                $arena->set($oldTeam . "Team", $getOldTeam - 1);
                $arena->set($teamC . "Team", $selTeam + 1);
                $arena->set("team." . $submitter->getName(), $teamC);
                $arena->save();

                $submitter->sendMessage("§fBed§cWars §8» §7Du bist nun in Team §r" . $colorCode->convertTeamToColorCode((string)$team) . "§7!");
            }
        } else {
            $submitter->sendMessage("§fBed§cWars §8» §7Das Team §r" . $colorCode->convertTeamToColorCode((string)$team) . " §7ist bereits voll!");
        }
    }
}